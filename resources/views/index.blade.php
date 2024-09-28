<!DOCTYPE html>
<html lang="en"> 
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="CA in Ahmedabad. Free CA Consulting, CA Consulting, best CA in the Ahmedabad, Neel R Patel, APK E-Services">
     <meta name="author" content="APK E-Services">
     <meta name="keywords" content="Neel R Patel Associates, CA Neel, CA in Ahmedabad, CA in Odhav, CA Near me, CA near ahmedabad, CA Near Odhav ring road, Free CA Consulting, CA Consulting, best CA in the Ahmedabad, Neel R Patel, APK E-Services">

     <link rel="preconnect" href="../fonts.gstatic.com/index.html">
     <link href="../fonts.googleapis.com/css283ac.css?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
         rel="stylesheet">
     <title>Neel R Patel & Associates</title>
     <link href="vendor_index/bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="assets_index/css/fontawesome.css">
     <link rel="stylesheet" href="assets_index/css/templatemo-space-dynamic.css">
     <link rel="stylesheet" href="assets_index/css/animated.css">
     <link rel="stylesheet" href="assets_index/css/owl.css">
     <style>
         .service-card {
             transition: transform 0.3s;
         }

         .service-card:hover {
             transform: scale(1.05);
         }
     </style>
 </head>

 <body>
     <div id="js-preloader" class="js-preloader">
         <div class="preloader-inner">
             <span class="dot"></span>
             <div class="dots">
                 <span></span>
                 <span></span>
                 <span></span>
             </div>
         </div>
     </div>

     @if(Session::has('adminCreatedMsg'))
        <script>
            alert("{{ Session::get('adminCreatedMsg') }}");
        </script>
    @endif

     <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
         <div class="container">
             <div class="row">
                 <div class="col-12">
                     <nav class="main-nav">
                         <a href="#top" class="logo">
                             <h4>Neel R Patel<span> & Associates</span></h4>
                         </a>
                         <ul class="nav">
                             <li class="scroll-to-section">
                                 <a href="#top" class="active">Home</a>
                             </li>
                             <li class="scroll-to-section">
                                 <a href="#about">About Us</a>
                             </li>
                             <li class="scroll-to-section">
                                 <a href="#services">Services</a>
                             </li>


                             <li class="scroll-to-section">
                                 <a href="#contact">Contact Us</a>
                             </li>
                             <li class="scroll-to-section">
                                 <div class="main-red-button">
                                     <a href="{{ url(route('login')) }}">Login</a>
                                 </div>
                             </li>
                         </ul>
                         <a class="menu-trigger">
                             <span>Menu</span>
                         </a>
                     </nav>
                 </div>
             </div>
         </div>
     </header>
     <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="row">
                         <div class="col-lg-6 align-self-center">
                             <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s"
                                 data-wow-delay="1s">
                                 <h6>Welcome to Neel R Patel & Associates</h6>
                                 <h2>
                                 Your<em> Business Partner</em><br>
                                     without sharing<br>
                                     your<span> Profit</span>
                                 </h2>
                                 <p>Since 2014 providing service in the field of accounting, audit, tax
                                     deductions, and other finance-related services.</p>
                                 <form id="search" action="#" method="GET">
                                     <fieldset>
                                         <input type="address" name="address" class="email"
                                             placeholder="Your website URL..." autocomplete="on"
                                             value="Book an appointment now!" required readonly>
                                     </fieldset>
                                     <fieldset>
                                        <button type="button" class="main-button" onclick="location.href='#contact'">Contact Us</button>
                                     </fieldset>
                                 </form>
                             </div>
                         </div>
                         <div class="col-lg-6">
                             <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                 <img src="assets_index/images/banner-right-image.png" alt="team meeting">
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div id="about" class="about-us section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-4">
                     <div class="left-image wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                         <img src="assets_index/images/about-left-image.png" alt="person graphic">
                     </div>
                 </div>
                 <div class="col-lg-8 align-self-center">
                     <div class="services">
                         <div class="row">
                             <div class="col-lg-6">
                                 <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                                     <div class="icon">
                                         <img src="assets_index/images/service-icon-01.png"
                                             alt="reporting">
                                     </div>
                                     <div class="right-text">
                                         <h4>Accounting & Bookkeeping</h4>
                                         <p>Accounting and bookkeeping services to ensure accurate financial records</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
                                     <div class="icon">
                                         <img src="assets_index/images/service-icon-02.png"
                                             alt="">
                                     </div>
                                     <div class="right-text">
                                         <h4>Tax Planning & Preparation</h4>
                                         <p>Individuals and Businesses minimize tax liabilities and maximize tax
                                             savings.</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.9s">
                                     <div class="icon">
                                         <img src="assets_index/images/service-icon-03.png"
                                             alt="">
                                     </div>
                                     <div class="right-text">
                                         <h4>Auditing & Assurance</h4>
                                         <p>Audit and Assurance services to provide financial statements.</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-6">
                                 <div class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="1.1s">
                                     <div class="icon">
                                         <img src="assets_index/images/service-icon-04.png"
                                             alt="">
                                     </div>
                                     <div class="right-text">
                                         <h4>Business Consulting</h4>
                                         <p>Strategic business consulting services to help companies improve
                                             performance.</p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div id="services" class="our-services section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                     <div class="left-image" style="align-items: center; display: flex; height: 100%;">
                         <img src="assets_index/images/services-left-image.png" alt="">
                     </div>
                 </div>
                 <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                     <div class="section-heading">
                         <h2 style="text-align: center;">
                             Grow your business with our
                             <em>Accounting</em>
                             service
                         </h2>
                         <p>Neel R Patel & Associates is a dedicated team of financial professionals providing expert
                             accounting, tax, and consulting services to individuals and businesses.</p>
                     </div>
                     <div class="row">
                         <div class="col-lg-4">
                             <div class="skill-card">
                                 <h4>Tax Planning & Preparation</h4>
                                 <i class="fa fa-calculator"></i>
                                 <p>Experience in minimizing tax liabilities and maximizing savings.</p>
                             </div>
                         </div>
                         <div class="col-lg-4">
                             <div class="skill-card">
                                 <h4>Financial Reporting & Analysis</h4>
                                 <i class="fa fa-bar-chart"></i>
                                 <p>Expert analysis and clear reports to inform your financial decisions.</p>
                             </div>
                         </div>
                         <div class="col-lg-4">
                             <div class="skill-card">
                                 <h4>Auditing & Assurance</h4>
                                 <i class="fa fa-check-square-o"></i>
                                 <p>Providing independent verification and enhancing financial transparency.</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="container mt-5">
         <div class="row">
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/income_tax.png" class="card-img-top"
                         alt="Income Tax">
                     <div class="card-body">
                         <h5 class="card-title">Income Tax</h5>
                         <p class="card-text">Worried on how to do tax planning? Does the income tax deadline panic
                             you? You can always count on our expert assistance for all your income tax-related queries.
                         </p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/audit.jpg" class="card-img-top" alt="Auditing">
                     <div class="card-body">
                         <h5 class="card-title">Auditing</h5>
                         <p class="card-text">Be it Tax Audit, GST Audit, Statutory Audit or any other Assurance
                             services; allow our experts to handle your auditing needs with precision and
                             professionalism.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/gst.jpg" class="card-img-top" alt="GST">
                     <div class="card-body">
                         <h5 class="card-title">GST</h5>
                         <p class="card-text">From GST Registration, preparation and filing of Returns and others,
                             representation, advisory... let our team guide you through the complexities of GST
                             compliance.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/company_formation.png" class="card-img-top"
                         alt="Company Formation">
                     <div class="card-body">
                         <h5 class="card-title">Company Formation</h5>
                         <p class="card-text">Incorporating a new company / LLP or Launching a new business, start it
                             with confidence with our expert assistance in company formation.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/corporate_compliances.png" class="card-img-top"
                         alt="Corporate Compliances">
                     <div class="card-body">
                         <h5 class="card-title">Corporate Compliances</h5>
                         <p class="card-text">Let complicated tax and compliance be made practical, to make it an
                             enabler for business growth with our comprehensive corporate compliance solutions.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/taxation.png" class="card-img-top"
                         alt="Taxation of Non-Residents">
                     <div class="card-body">
                         <h5 class="card-title">Taxation</h5>
                         <p class="card-text">Our services cater to the unique taxation needs of non-residents,
                             ensuring compliance with both Indian and foreign tax regulations.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/accounting.jpg" class="card-img-top"
                         alt="Accounting">
                     <div class="card-body">
                         <h5 class="card-title">Accounting</h5>
                         <p class="card-text">Looking for a permanent solution to keep your books of accounts updated?
                             You can count on our meticulous accounting services to maintain financial clarity.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/tds.jpg" class="card-img-top" alt="TDS">
                     <div class="card-body">
                         <h5 class="card-title">TDS</h5>
                         <p class="card-text">Want to know about your TDS? Our experts will help you navigate the
                             complexities of Tax Deducted at Source.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/sme.jpg" class="card-img-top" alt="SME">
                     <div class="card-body">
                         <h5 class="card-title">SME</h5>
                         <p class="card-text">SMEs are the backbone of the Indian economy. Let us support your SME's
                             growth with our comprehensive financial solutions tailored to your needs.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/advisory.jpg" class="card-img-top"
                         alt="Finance & Advisory">
                     <div class="card-body">
                         <h5 class="card-title">Finance & Advisory</h5>
                         <p class="card-text">Whether your business aims to raise capital, grow through acquisitions,
                             or optimize its financial performance, our expert advisory services are here to assist you.
                         </p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/government_grants_subsidies.png" class="card-img-top"
                         alt="Government Grants & Subsidies">
                     <div class="card-body">
                         <h5 class="card-title">Government Grants & Subsidies</h5>
                         <p class="card-text">Subsidies and grants play a crucial role in the economic development of
                             countries like ours. Let us help you navigate the landscape of government incentives for
                             your business.</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-4">
                 <div class="card service-card">
                     <img src="assets_index/images/tax_advisory.jpg" class="card-img-top"
                         alt="Tax Advisory">
                     <div class="card-body">
                         <h5 class="card-title">Tax Advisory</h5>
                         <p class="card-text">At Piyush J. Shah & Co., we offer dedicated tax advisory services to help
                             businesses navigate the complexities of taxation, ensuring compliance and minimizing risks.
                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div id="contact" class="contact-us section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="0.5s"
                     data-wow-delay="0.25s">
                     <div class="section-heading">
                         <h2>Feel Free To Contact Us</h2>
                         <p>Our expert will guide you.</p>
                         <div class="phone-info">
                             <h4>
                                 <span>
                                     <i class="fa fa-phone"></i>
                                     <a href="tel:9327622459">9327622459</a>
                                 </span>
                             </h4>
                             <h4 class="mt-2">
                                 <span>
                                     <i class="fa fa-phone"></i>
                                     <a href="tel:9723639670">9723639670</a>
                                 </span>
                             </h4>
                             <h4 class="mt-2">
                                 <span>
                                     <i class="fa fa-envelope"></i>
                                     <a href="mailto:Neel9042@gmail.com">Neel9042@gmail.com</a>
                                 </span>
                             </h4>
                             <h4 class="mt-2">
                                 <span class="d-flex flex-row">
                                     <i class="fa fa-map-marker"></i>
                                     <a style="width: 21rem;">FF 1-5, 9-10, SIDDHI VINAYAK ARCADE ODHAV CROSS ROAD,
                                         Sardar Patel Ring Rd, near SHABRI HOTEL, Odhav, Ahmedabad, Gujarat 382430</a>
                                 </span>
                             </h4>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-6 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
                     <div class="google-map">
                         <iframe
                             src="../www.google.com/maps/embed5514.html?pb=!1m14!1m8!1m3!1d14687.108755524301!2d72.6529959!3d23.0319518!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e87068bab1ee9%3A0x9e68c4a2acf12aa!2sNEEL%20R.%20PATEL%20%26%20ASSOCIATES!5e0!3m2!1sen!2sin!4v1714938078862!5m2!1sen!2sin"
                             width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy"
                             referrerpolicy="no-referrer-when-downgrade"></iframe>
                     </div>
                 </div>


             </div>
         </div>
     </div>
     <footer>
         <div class="container">
             <div class="row">
                 <div class="col-lg-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
                     <p>
                         © Copyright
                         <script>
                             document.write(new Date().getFullYear());
                         </script>
                         Neel R Patel & Associates All Rights Reserved.
                         <br>
                         Developed by
                         <a rel="nofollow" href="../apkeservices.com/index.html">APK E-Service</a>
                     </p>
                 </div>
             </div>
         </div>
     </footer>
     <!-- Scripts -->
     <script src="vendor_index/jquery/jquery.min.js"></script>
     <script src="vendor_index/bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="assets_index/js/owl-carousel.js"></script>
     <script src="assets_index/js/animation.js"></script>
     <script src="assets_index/js/imagesloaded.js"></script>
     <script src="assets_index/js/templatemo-custom.js"></script>
 </body>

 
</html>
