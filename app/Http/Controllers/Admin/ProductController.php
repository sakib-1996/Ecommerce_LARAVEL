<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductQty;
use App\Models\ProductSEO;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Json;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productQtys', 'discounts')->get();
        return view('admin.pages.product.index', compact('products'));
    }


    public function createProductPage()
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('admin.pages.product.create', compact('categories', 'brands'));
        // dd($request->all());
    }

    public function createProduct(Request $request)
    {
        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'product_id' => 'required|unique:products,product_id',
            'weight' => 'nullable|string',
            'minimum_purchase' => 'required|string',
            'thum_img' => 'required|image|mimes:jpeg,png,webp,jpg|max:2048',
            'short_des' => 'required|string',
            'category_id' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $product = new Product;
            $product->title = $request->title;
            $product->slug = Str::slug($request->title, '-');
            $product->product_id = '#' . $request->product_id;
            $product->brand_id = $request->brand_id;
            $product->cat_id = $request->category_id;
            $product->subCat_id = $request->subCat_id;
            $product->childCat_id = $request->childCat_id;
            $product->weight = $request->weight;
            $product->short_des = $request->short_des;
            $product->minimum_purchase = $request->minimum_purchase;
            $product->barcode = $request->barcode;

            $product->type = $request->type;

            $product->description = $request->description;
            $product->related_product = $request->related_products;

            $product->refundable = $request->has('refundable') ? 1 : 0;
            $product->cash_on_delivary = $request->has('cash_on_delivary') ? 1 : 0;

            $product->thum_img = 'files/product/' . $this->handleImageUpload($request->file('thum_img'), 'public/files/product/');
            // Save the product
            $product->save();
            // Create and save SEO properties for the product
            $tagsJson = json_encode($request->tags);
            $seoProperty = new ProductSEO;
            $seoProperty->product_id = $product->id;
            $seoProperty->meta_title = $request->meta_title;
            $seoProperty->meta_des = $request->meta_des;
            $seoProperty->meta_slug = $request->meta_slug;
            $seoProperty->tags = $tagsJson;

            // dd($product->id);
            // Handle SEO thumbnail image upload
            if ($request->meta_img) {

                $seoProperty->meta_img = 'files/product_seo/' . $this->handleImageUpload($request->file('meta_img'), 'public/files/product_seo/');
            }
            $seoProperty->save();

            // Handle product images upload
            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $productImg = new ProductImage;
                    $productImg->product_id = $product->id;
                    $productImg->product_img = 'files/product_Img/' . $this->handleImageUpload($image, 'public/files/product_Img/');
                    $productImg->save();
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            $notification = ['message' => 'Product Inserted!', 'alert-type' => 'success'];
            return redirect()->route('products.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            // Log::error("sjkdhfus" . $e);
            $notification = ['message' => 'Failed to insert product!', 'alert-type' => 'error'];
            return redirect()->back()->withInput()->with($notification);
        }
    }



    public function editeProductPage($productId)
    {
        $categories = Category::get();
        $brands = Brand::get();
        $product = Product::find($productId);
        $relatedProducts = [];

        if (!empty($product->related_product)) {
            if (is_string($product->related_product)) {
                $relatedProducts[] = $product->related_product;
            } elseif (is_array($product->related_product)) {
                $relatedProducts = $product->related_product;
            }
        }
        $seoProperty = ProductSEO::find($productId);
        $images = ProductImage::where('product_id', $productId)->get();

        return view('admin.pages.product.editeProduct', compact('product', 'categories', 'brands', 'images', 'seoProperty', 'relatedProducts'));
    }


    public function updateProduct(Request $request, $productId)
    {
        // dd($request->category_id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'product_id' => [
                'required',
                Rule::unique('products', 'product_id')->ignore($productId),
            ],
            'weight' => 'nullable|string',
            'minimum_purchase' => 'required|string',
            'short_des' => 'required|string',
            'category_id' => 'required',
            'free_shipping' => 'nullable',
        ]);
        if (!$request->has('free_shipping')) {
            $validator->addRules(['width' => 'required|string']);
        }
        if (!$request->has('free_shipping')) {
            $validator->addRules(['length' => 'required|string']);
        }
        $validator->validate();


        DB::beginTransaction();

        try {
            $product = Product::findOrFail($productId);
            // dd($product->cash_on_delivary);

            $product->update([
                // type
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'product_id' => '#' . str_replace('#', '', $request->product_id),
                'brand_id' => $request->brand_id,
                'type' => $request->type,
                'cat_id' => $request->category_id,
                'subCat_id' => $request->subCat_id,
                'childCat_id' => $request->childCat_id,
                'weight' => $request->weight,
                'minimum_purchase' => $request->minimum_purchase,
                'tags' => $request->tags,
                'short_des' => $request->short_des,

                'free_shipping' => $request->filled('free_shipping'),
                'width' => $request->width,
                'length' => $request->length,

                'barcode' => $request->barcode,
                'description' => $request->description,
                'related_product' => $request->related_products,
                'cash_on_delivary' => $request->filled('cash_on_delivary'),
                'refundable' => $request->filled('refundable'),
            ]);

            // Handle thumbnail image update
            if ($request->hasFile('thum_img')) {
                $oldThumPath = public_path('storage/' . $product->thum_img);
                if (File::exists($oldThumPath)) {
                    unlink($oldThumPath);
                }
                $product->update(['thum_img' => 'files/product/' . $this->handleImageUpload($request->file('thum_img'), 'public/files/product/')]);
            }

            // Update product SEO attributes
            $productSeo = ProductSEO::where('product_id', $productId)->first();
            $productSeo->update([
                'meta_title' => $request->meta_title,
                'meta_des' => $request->meta_des,
                'meta_slug' => $request->meta_slug,
                'meta_img' => $request->hasFile('meta_img') ? 'files/product_seo/' . $this->handleImageUpload($request->file('meta_img'), 'public/files/product_seo/') : $request->oldMeta_img,
            ]);

            // Delete unused product images
            $allImages = ProductImage::where('product_id', $productId)->pluck('product_img')->toArray();
            $unusedImages = array_diff($allImages, (array)$request->old_images);
            foreach ($unusedImages as $unusedImage) {
                $imagePath = public_path('storage/' . $unusedImage);
                if (File::exists($imagePath)) {
                    unlink($imagePath);
                }
                ProductImage::where('product_img', $unusedImage)->delete();
            }

            // Add new product images
            if ($request->has('images')) {
                foreach ($request->file('images') as $newImage) {
                    ProductImage::create([
                        'product_id' => $productId,
                        'product_img' => 'files/product_Img/' . $this->handleImageUpload($newImage, 'public/files/product_Img/')
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['message' => 'Failed to update product. Please try again.'])->withInput();
        }

        $notification = ['message' => 'Product updated successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    public function deleteProduct($productId)
    {
        // Check if the product exists
        $product = Product::find($productId);
        if (!$product) {

            $notification = ['message' => 'Product Not Found !', 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        // Delete the thumbnail image
        $productImg = $product->thum_img;
        $imagePath = public_path('storage/' . $productImg);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the SEO image
        $productSeo = ProductSEO::where('product_id', $productId)->first();
        // dd($productSeo);
        if ($productSeo->meta_img) {
            $producSeotImg = $productSeo->meta_img;
            $seoImagePath = public_path('storage/' . $producSeotImg);
            if (File::exists($seoImagePath)) {
                unlink($seoImagePath);
            }
        }

        // Delete the product
        $productSeo->delete();
        $product->delete();

        // Redirect back with a success message
        $notification = ['message' => 'Product Deleted successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }



    public function addQtyPage($productId)
    {
        $product = Product::find($productId);
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.pages.product.addQty', compact('product', 'sizes', 'colors'));
    }

    public function addQty(Request $request, $productId)
    {
        $request->validate([
            'qty' => 'required|numeric',
            'unit_price' => 'required',
            'purchase_price' => 'required',
            'size_id' => 'required_without_all:color_id,unit',
            'color_id' => 'required_without_all:size_id,unit',
            'unit' => 'required_without_all:size_id,color_id',
        ]);

        ProductQty::create([
            'qty' => $request->qty,
            'unit_price' => $request->unit_price,
            'purchase_price' => $request->purchase_price,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'unit' => $request->unit,
            'current_qty' => $request->qty,
            'product_id' => $productId,
            'sku' => $this->generateUniqueID(5)

        ]);
        $product = Product::find($productId);
        $product->update(['status' => true]);
        // Redirect back with a success message
        $notification = ['message' => 'Quantity Inserted!', 'alert-type' => 'success'];
        return redirect()->route('products.QtyDetails', $productId)->with($notification);
    }

    public function QtyDetails($productId)
    {
        $productQtys = ProductQty::where('product_id', $productId)
            ->with('size', 'color')
            ->get();
        $product = Product::find($productId);
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.pages.product.productQtyDetails', compact('productQtys', 'product', 'sizes', 'colors'));
    }


    public function QtyById($qtyId)
    {
        $qtyByid = ProductQty::find($qtyId);
        return response()->json($qtyByid);
    }


    public function QtyUpdate(Request $request)
    {
        $rules = [
            'unit_price' => 'required|numeric',
            'qty' => 'required',
            'purchase_price' => 'required|numeric',
            'size_id' => 'required_without_all:color_id,unit',
            'color_id' => 'required_without_all:size_id,unit',
            'unit' => 'required_without_all:size_id,color_id',
        ];

        $validatorMessages = [
            'unit_price.required' => 'Unit price is required.',
            'qty.required' => 'Qty  is required.',
            'unit_price.numeric' => 'Unit price must be a number.',
            'purchase_price.required' => 'Purchase price is required.',
            'purchase_price.numeric' => 'Purchase price must be a number.',
            'size_id.required_without_all' => 'Size is required when neither color nor unit is provided.',
            'color_id.required_without_all' => 'Color is required when neither size nor unit is provided.',
            'unit.required_without_all' => 'Unit is required when neither size nor color is provided.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);

        if ($validator->fails()) {
            $errorMessage = implode($validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }
        // dd($request->id);

        if ($request->id) {
            $productQty = ProductQty::find($request->id);
            $unit = substr($request->unit, 0, 255);
            // dd($unit);
            $productQty->update([
                'unit_price' => $request->unit_price,
                'qty' => $request->qty,
                'current_qty' => $request->qty,
                'purchase_price' => $request->purchase_price,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
                'unit' => $unit,
            ]);

            $notification = ['message' => 'Quantity Updated!', 'alert-type' => 'success'];
            return redirect()->back()->with($notification);
        }

        $notification = ['message' => 'Quantity Not Found !', 'alert-type' => 'error'];
        return redirect()->back()->with($notification);
    }

    public function QtyDelete($qtyId)
    {
        ProductQty::find($qtyId)->delete();

        $notification = ['message' => 'Quantity Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    public function QtyDruftUpdate($qtyId)
    {
        // dd($id);
        $qtyStatus = ProductQty::findOrFail($qtyId);
        $newStatus = $qtyStatus->druft == 0 ? 1 : 0;
        // dd($newStatus);
        $qtyStatus->update(['druft' => $newStatus]);
        return back();
    }

    public function ProductDruftUpdate($productId)
    {
        // dd($productId);
        $productDrStatus = Product::findOrFail($productId);
        $newDrStatus = $productDrStatus->druft == 0 ? 1 : 0;
        // dd($newDrStatus);
        $productDrStatus->update(['druft' => $newDrStatus]);
        return back();
    }


    public function productsByName(Request $request)
    {
        $query = $request->input('query');

        // Search for products by title
        $products = Product::where('title', 'like', "%" . $query . "%")
            ->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found.']);
        }

        return response()->json($products);
    }







    private function handleImageUpload($imageFile, $directory)
    {
        // dd($imageFile);
        $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $image = Image::make($imageFile)->fit(900, 900)->encode();
        Storage::put($directory . $imageName, $image);
        // dd($imageName);
        return $imageName;
    }

    private function generateUniqueID($length)
    {
        $characters = '0123456789abcde';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
