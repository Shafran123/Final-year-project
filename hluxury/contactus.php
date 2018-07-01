<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';
?>
<div id="contact-page" class="container">
   <div class="bg">
     <div class="row">
       <div class="col-sm-12">
       <h2 class="title text-center">Contact <strong>Us</strong></h2>
       <div id="gmap" class="contact-map">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31916.296170035075!2d34.7600382171248!3d-0.680374118232295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182b3becb25f4161%3A0x44516a90c78b2db1!2sKisii%2C+Kenya!5e0!3m2!1sen!2s!4v1499084183126" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
       </div>
     </div>
   </div>
     <div class="row">
       <div class="col-sm-8">
         <div class="contact-form">

           <h2 class="title text-center">Get In Touch</h2>
           <div class="status alert alert-success" style="display: none"></div>
           <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="sendemail.php">
                 <div class="form-group col-md-6">
                     <input type="text" name="name" class="form-control" required="required" placeholder="Name" >
                 </div>
                 <div class="form-group col-md-6">
                     <input type="email" name="email" class="form-control" required="required" placeholder="Email">
                 </div>
                 <div class="form-group col-md-12">
                     <input type="text" name="subject" class="form-control" required="required" placeholder="Subject">
                 </div>
                 <div class="form-group col-md-12">
                     <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
                 </div>
                 <div class="form-group col-md-12">
                     <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit">
                 </div>
             </form>
         </div>
       </div>
       <div class="col-sm-4">
         <div class="contact-info">
           <h2 class="title text-center">Contact Info</h2>
           <address>
             <p>H-Luxury & Co</p>
             <p>27 Central London</p>
             <p>London</p>
             <p>Mobile: +44 7019646365</p>
             <p>Email: Hluxury@gmail.com</p>
           </address>
           <div class="social-networks">
<a class="twitter-timeline" data-width="500" data-height="200" href="https://twitter.com/Twitter?ref_src=twsrc%5Etfw">Tweets by Twitter</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div><!--/#contact-page-->
<?php
include 'include/footer.php';
?>
