   <!-- START SECTION BREADCRUMB -->
   <div class="breadcrumb_section bg_gray page-title-mini">
       <div class="container"><!-- STRART CONTAINER -->
           <div class="row align-items-center">
               <div class="col-md-6">
                   <div class="page-title">
                       <h1>Contact</h1>
                   </div>
               </div>
               <div class="col-md-6">
                   <ol class="breadcrumb justify-content-md-end">
                       <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                       <li class="breadcrumb-item">Pages</li>
                       <li class="breadcrumb-item active">Contact</li>
                   </ol>
               </div>
           </div>
       </div><!-- END CONTAINER-->
   </div>
   <!-- END SECTION BREADCRUMB -->

   <!-- START MAIN CONTENT -->
   <div class="main_content">
       <!-- START SECTION CONTACT -->
       <div class="pb_70">
           <div class="container">
               <div class="row">
                   <div class="col-xl-4 col-md-6">
                       <div class="contact_wrap contact_style3">
                           <div class="contact_icon">
                               <i class="linearicons-map2"></i>
                           </div>
                           <div class="contact_text">
                               <span>Address</span>
                               <p>{{ $contact ? $contact->address : '' }}</p>
                           </div>
                       </div>
                   </div>
                   <div class="col-xl-4 col-md-6">
                       <div class="contact_wrap contact_style3">
                           <div class="contact_icon">
                               <i class="linearicons-envelope-open"></i>
                           </div>
                           <div class="contact_text">
                               <span>Email Address</span>
                               <a href="mailto:info@sitename.com">{{ $contact ? $contact->email : '' }}</a>
                           </div>
                       </div>
                   </div>
                   <div class="col-xl-4 col-md-6">
                       <div class="contact_wrap contact_style3">
                           <div class="contact_icon">
                               <i class="linearicons-tablet2"></i>
                           </div>
                           <div class="contact_text">
                               <span>Phone</span>
                               <p>{{ $contact ? $contact->phone : '' }}</p>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- END SECTION CONTACT -->

       <!-- START SECTION CONTACT -->
       <div class="section pt-0">
           <div class="container">
               <div class="row">
                   <div class="col-lg-6">
                       <div class="heading_s1">
                           <h2>Get In touch</h2>
                       </div>
                       <p class="leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit
                           massa
                           enim. Nullam id varius nunc id varius nunc.</p>
                       <div class="field_form">
                           <form method="post" action="{{ route('contactMessage') }}" enctype="multipart/form-data">
                               @csrf
                               <div class="row">
                                   <div class="form-group col-md-6 mb-3">
                                       <input placeholder="Enter Name *"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           type="text" value="{{ old('name') }}">
                                       @error('name')
                                           <small class="text-danger">{{ $message }}</small>
                                       @enderror
                                   </div>
                                   <div class="form-group col-md-6 mb-3">
                                       <input placeholder="Enter Email *"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           type="email" value="{{ old('email') }}">
                                       @error('email')
                                           <small class="text-danger">{{ $message }}</small>
                                       @enderror
                                   </div>
                                   <div class="form-group col-md-6 mb-3">
                                       <input placeholder="Enter Phone No. *"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}">
                                       @error('phone')
                                           <small class="text-danger">{{ $message }}</small>
                                       @enderror
                                   </div>
                                   <div class="form-group col-md-6 mb-3">
                                       <input placeholder="Enter Subject"
                                           class="form-control @error('subject') is-invalid @enderror" name="subject"
                                           value="{{ old('subject') }}">
                                       @error('subject')
                                           <small class="text-danger">{{ $message }}</small>
                                       @enderror
                                   </div>
                                   <div class="form-group col-md-12 mb-3">
                                       <textarea placeholder="Message *" id="description" class="form-control @error('message') is-invalid @enderror"
                                           name="message" rows="4">{{ old('message') }}</textarea>
                                       @error('message')
                                           <small class="text-danger">{{ $message }}</small>
                                       @enderror
                                   </div>
                                   <div class="col-md-12 mb-3">
                                       <button type="submit" title="Submit Your Message!" class="btn btn-fill-out">Send
                                           Message</button>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                       <div id="alert-msg" class="alert-msg text-center"></div>
                                   </div>
                               </div>
                           </form>

                       </div>

                   </div>
                   <div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">
                       <div id="map" class="contact_map2" data-zoom="12" data-latitude="40.680"
                           data-longitude="-73.945" data-icon="{{ asset('frontend') }}/assets/images/marker.png"></div>
                   </div>
               </div>
           </div>
       </div>
       <!-- END SECTION CONTACT -->
   </div>
   <!-- END MAIN CONTENT -->



   <!-- Leaflet JavaScript -->
   <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
   <script>
       var map = L.map('map').setView([24.7575, 90.4067], 12);

       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
       }).addTo(map);

       L.marker([24.7575, 90.4067], {
           icon: L.icon({
               iconUrl: '{{ asset('frontend') }}/assets/images/marker.png',
               iconSize: [30, 30]
           })
       }).addTo(map);
   </script>
