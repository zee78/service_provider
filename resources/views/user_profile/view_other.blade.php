@extends('layouts.app')

@section('content')
<?php
if (\Session::has('u_session')) {
  $name=session()->get('u_session')->name;
  $email=session()->get('u_session')->email;
  $phone=session()->get('u_session')->phone;
}else{
  $name="";
  $email="";
  $phone="";
}

 ?>
<!--     Profile view       -->
<div class="container " id="custom_profile">
  <div class="eo-box">
    <div class="eo-timeline">
      <!--  Cover image  -->
      <?php if (!empty($user->cover_img)): ?>
        <img src="{{url('img/cover/'.$user->cover_img)}}" class="eo-timeline-cover" alt="{{$user->cover_img}}">
      <?php else: ?>
        <img src="{{asset('images/nocover.jpg')}}" class="eo-timeline-cover" alt="{{$user->cover_img}}">
      <?php endif; ?>
      <!--  Cover image  -->
      <input type="file" id="cover" name="cover_img"  class="compnay-cover sp-cover">
      <div class="eo-timeline-toolkit" id="cover_change">
        <label for="cover"><i class="fa fa-camera" ></i> &nbsp;Change</label>
      </div>
    </div>  <!-- cover img end -->
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-2 eo-dp-box">      <!--  Profile image  -->
          <?php if (!empty($user->image)): ?>
            <img src="{{url('img/profile/'.$user->image)}}" class=" eo-dp eo-c-logo " alt="{{$user->image}}">
          <?php else: ?>
            <img src="{{asset('img/profile-logo.jpg')}}" class=" eo-dp eo-c-logo " alt="{{$user->image}}">
          <?php endif; ?>
          <div class="eo-dp-toolkit" id="profile_img_change">
            <input type="file" id="eo-dp" name="profile-image" class="compnay-logo pf-image-change">
            <label for="eo-dp"><i class="fa fa-camera"></i> change</label><br>
            <label  style="margin-left:-23px" onclick="editcompanypic()"><i class="fa fa-edit"></i>Edit</label><br>
            <label onclick="removecompanypic()"><i class="fa fa-remove">
              <input type="hidden" value="{{ $user->id }}" id="userID">
            </i> Remove</label>
          </div>

        </div>   <!-- profile img end -->

        <div class="col-md-10 eo-timeline-details">    <!-- Profile view div  -->
          <h2><a style="color: white;" href="#"> {{ $user->name }}</a></h2>
          <div class="col-md-6 eo-section">

            <!-- Image Loader -->
            <div id="loaderIcon" class="loaderIcon" style="display: none;"><img src="{{ asset('images/Spinner.gif')}}" alt="">
            </div>
            <!-- Image Loader Ends -->

            <h4>Basic Information</h4>
            <div class="eo-details provider s_user_hide">
              <span>Skills:</span> {{$user->skill}}
            </div>
            <div class="eo-details">
              <span>Address:</span> {{ $user->location }}
            </div>
            <div class="eo-details">
              <span>Email:</span> {{ $user->email }}
            </div>
            <!-- <div class="eo-details">
              <span>Phone:</span> {{ $user->phone }}
            </div> -->
            <div class="eo-details provider s_user_hide">
              <span>Experience:</span>{{ $user->experience }}
            </div>
            <div class="eo-details provider s_user_hide">
              <span>Examination Fee:</span> {{$user->fee}}  Rs.
            </div>
          </div>
          <div class="col-md-5 eo-section">    <!-- edit buttion -->
            <a class="btn btn-primary eo-edit-btn" id="edit_btn" onClick="$('.eo-section').hide(); $('.eo-edit-section').show()"><i class="fa fa-edit"></i> </a>
          </div>
          <div class="col-md-1 eo-section">    <!-- edit buttion -->
            @if(\Session::has('u_session'))
              <button id="hire_btn" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$user->id}}">Hire Now</button>
            @else
            <a  href="{{url('/login')}}" class="btn btn-success">Hire Now</a>
            @endif
            <!-- <a class="btn btn-success" href="{{url('/user/hire/'.$user->id)}}" id="hire_btn">Hire Now </a> -->
          </div>


          <div class="modal fade" id="myModal{{$user->id}}" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Hire Now</h4>
                </div>
                <form class="" action="#" id="rating_form{{$user->id}}">
                  {{csrf_field()}}
                <div class="modal-body text-center">
                  <p>Do you want to hire {{$user->name}}.</p>
                  <div class="row">
                    <div class="form-group col-md-6 col-md-offset-3">
                    <input type="text" name="user_name" id="user_name" class="form-control" value="{{$name}}" placeholder="Your Name">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6 col-md-offset-3">
                    <input type="email" class="form-control" name="user_email" id="user_email" value="{{$email}}" placeholder="Your Email">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6 col-md-offset-3">
                    <input type="text" class="form-control" name="user_phone" id="user_phone" value="{{$phone}}" placeholder="Your Phone">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6 col-md-offset-3">
                      <textarea name="message" id="user_issue" class="form-control"  style="min-height: 150px;" placeholder="What is Your Issue"></textarea>
                    </div>
                    </div>
                    <input type="hidden" name="provider_id" id="provider_id" value="{{$user->id}}">
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-success sub_btn" onclick="new_hire({{$user->id}})">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
              </div>

            </div>
          </div>


          <div class="eo-edit-section">   <!-- Edit section start -->
            <form id="pnj-form" class="form-update" action="{{url('update/'.$user->id)}}" method="post">   <!-- Update Form start -->
              {{csrf_field()}}
              <!-- <input type="hi.dden" name="" class="token"> -->
              <div class="pnj-form-section">
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">Name</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="text" class="form-control" name="name" id="companyName" placeholder="Name" value="{{ $user->name }}" required>
                  </div>
                </div><br><br><br>
                <div class="form-group provider">     <!-- Skill slection -->
                  <label class="control-label col-sm-3 col-xs-12">Skills</label>
                  <div class="col-sm-9 pnj-form-field">
                    <select class="form-control select2" name="skill">
                      <?php if (!empty($user->skill)): ?>
                        <option value="{{ $user->skill }}"selected> {{ $user->skill }}</option>
                      <?php else: ?>
                        <option value="" selected> Select Skill</option>
                      <?php endif; ?>
                      <option value="Plumber"> Plumber</option>
                      <option value="Electrician" >Electrician</option>
                      <option value="Welder "> Welder</option>
                      <option value="Painter" >Painter</option>
                      <option value="Carpenter"> Carpenter</option>
                      <option value="Mechanic" >Mechanic</option>
                      <option value="Cook" >cook</option>
                      <option value="Gardener"> Gardener</option>
                      <option value="Sweeper" >Sweeper</option>
                    </select>
                  </div>
                </div>   <!-- Skill slection end -->
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">phone</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $user->phone}}" required>
                  </div>
                </div>
                <div class="form-group pwd">
                  <label class="control-label col-sm-3 col-xs-12">Password</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="password" class="form-control" name="password" placeholder="Password" value="{{ $user->password }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">Email</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="email" class="form-control " name="email" placeholder="Email" value="{{ $user->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">Location</label>
                  <div class="col-sm-9 pnj-form-field">
                    <div id="locationField">
                      <input id="locality1" name="location" class="form-control" value="{{$user->location}}" placeholder="Select your location"
                      type="text"></input>
                      <!-- <input type="hidden" name="" value="{{$user->location}}"> -->
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">address</label>
                  <div class="col-sm-9 pnj-form-field">
                    <textarea required class="form-control " placeholder="Address" name="address" style="resize: vertical">{{ $user->address }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">country</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input class="field form-control" name="country" value="{{$user->country}}" id="country"></input>
                  </div>
                </div>
                <input type="hidden"  name="latitude" id="latitude">
                <input type="hidden"  name="longitude" id="longitude">
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">state</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input class="field form-control" name="state" value="{{$user->state}}" id="administrative_area_level_1"></input>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 col-xs-12">city</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input class="field form-control" name="city" value="{{$user->city}}"  id="locality"></input>
                  </div>
                </div>
                <div class="form-group provider">
                  <label class="control-label col-sm-3 col-xs-12">Fee</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="text" class="form-control" name="fee" placeholder="1000" value="{{ $user->fee }}">
                  </div>
                </div>
                <div class="form-group provider">
                  <label class="control-label col-sm-3 col-xs-12">Experience</label>
                  <div class="col-sm-9 pnj-form-field">
                    <input type="text" class="form-control" name="experience" placeholder="2 Years" value="{{ $user->experience }}">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">    <!-- Form Buttons here -->
                      <button type="submit" class="btn btn-primary col-md-3" id="page_submit" name="save" >SAVE</button>
                      <button type="button" class="btn btn-default col-md-3" onClick="$('.eo-edit-section').hide(); $('.eo-section').show()">CANCEL</button>
                    </div>
                  </div>
                </div>
              </div>  <!-- pnj-form-section ends -->
            </form> 	<!-- Update Form  end -->
          </div>      <!--  Edit section end -->
        </div>      <!-- Profile view end -->
      </div>
    </div>
  </div>    <!-- eo-box end -->


  <!-- about Gallery -->
  <div class="eo-box eo-about">
    <!-- <a class="btn btn-primary r-add-btn hideThis" id="about_btn" onClick="$('.eo-about-org').hide(); $('.hideThis').hide();$('.eo-about-editor').show(); "><i class="fa fa-edit"></i> </a> -->
    <h3 class="eo-about-heading">Gallery</h3>
    <div class="eo-about-org" style="padding-left:30px">
      <p><span></span></p>
    </div>
    <div class=""> <!-- about editior -->
      <div id="w_error" class="alert alert-danger alert-dismissible" style="display: none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span>Please Enter Category Name and Picture</span>
      </div>
      <div id="worker_success" class="alert alert-success alert-dismissible" style="display: none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span>New image added Successfully</span>
      </div>
      <div class="individual-form hide_other">

      <form action="#" id="pnj-form1" method="post" class="organization-desc-form">
        {{csrf_field()}}
        <input type="hidden" name="" class="token">
        <div class="form-group" style="padding-left:20px">
          <label class="control-label col-sm-3">&nbsp;</label>
          <!-- <div class="col-sm-7 pnj-form-field"> -->
            <!-- <textarea class="form-control tex-editor" name="companyAbout" rows="10"> </textarea> -->
            <div class="form-group col-md-2">
              <label>Working Picture</label><br>
              <label class="btn btn-file" for="w_image">Upload Picture
                <input type="file" name="w_image" id="w_image">
              </label>
            </div>
          <!-- </div> -->
        </div>

      </form>
      </div>
      @if(count($user_gallery)>0)
      @foreach(($user_gallery) as $gallery)
      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
          <div class="">
              <div class="row">

                  <div class="col-sm-12 text-center">
                    <div class="profile-show">
                        <img src="{{url('img/gallery/'.$gallery->g_image)}}" class="pf-image" alt="">
                    </div>
                    </div>
              </div>
          </div>
      </div>
      @endforeach
      @endif


</div>   <!-- about div end -->
</div>  <!-- about Gallery end -->

  <!-- about editor -->
  <div class="eo-box eo-about" id="eo-about" >
    <a class="btn btn-primary r-add-btn hideThis" id="about_btn" onClick="$('.eo-about-org').hide(); $('.hideThis').hide();$('.eo-about-editor').show(); "><i class="fa fa-edit"></i> </a>
    <h3 class="eo-about-heading">About Me</h3>
    <div class="eo-about-org" style="padding-left:30px">
      <p><span></span></p>
    </div>
    <div class="eo-about-editor"> <!-- about editior -->
      <form action="#" id="pnj-form1" method="post" class="organization-desc-form">
        <input type="hidden" name="" class="token">
        <div class="form-group" style="padding-left:20px">
          <label class="control-label col-sm-3">&nbsp;</label>
          <div class="col-sm-7 pnj-form-field">
            <textarea class="form-control tex-editor" name="companyAbout" rows="10"> </textarea>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-primary col-md-3 edit-about-btn" name="save" >SAVE</button>
              <button type="button" class="btn btn-default col-md-3 edit-about-btn" onClick="$('.eo-about-org').show(); $('.hideThis').show();$('.eo-about-editor').hide();">CANCEL</button>
            </div>
          </div>
        </div>
      </form>
      <script>
      CKEDITOR.replace( 'companyAbout' );
    </script>
  </div>  <!-- about editior end -->
</div>   <!-- about div end -->
</div> 	<!-- container end -->
<script>

function initializeAutocomplete(){
  var input = document.getElementById('locality1');
  // var options = {
  //   types: ['(regions)'],
  //   componentRestrictions: {country: "IN"}
  // };
  var options = {}

  var autocomplete = new google.maps.places.Autocomplete(input,options);

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    // to set city name, using the locality param
    var componentForm = {
      locality1: 'short_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      locality: 'long_name'
    };
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
    }
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;

  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1RaWWrKsEf2xeBjiZ5hk1gannqeFxMmw&libraries=places&callback=initializeAutocomplete"
async defer></script>

<!-- hide profile image edit button  -->
<script>
$(document).ready(function () {
$(".pwd").hide();
  <?php
  if (\Session::has('u_session')) {

  $session = session()->get('u_session');
  if ($session->type == 'serviceUser') { ?>
    $(".provider").hide();
    <?php  }
    }
    ?>
  });
</script>
<script>
$(document).ready(function () {
  <?php
  if (\Session::has('u_session')) {

  $session = session()->get('u_session');
  if ($session->type == 'provider') { ?>
    // $(".s_user").hide();
    // $(".provider").show();
    <?php  }
  }
    ?>
  });
</script>
<script>
$(document).ready(function () {

  <?php
  $id='';
    if (\Session::has('u_session')) {
  $id = session()->get('u_session')->id;
  if ($id != $user->id) { ?>
    $("#edit_btn").hide();
    $("#eo-about").hide();
    $("#eo-about1").hide();
    $(".hide_other").hide();
    $("#cover_change").hide();
    $(".provider").show();
    $("#profile_img_change").hide();
    <?php  }
  }elseif ($id == $user->id) {?>
    $("#edit_btn").hide();
    $("#eo-about").hide();
    $("#eo-about1").hide();
    $("#hire_btn").hide();
    $("#cover_change").hide();
    $(".provider").show();
    $("#profile_img_change").hide();

    <?php }else {?>
      $(".hide_other").hide();
      $("#edit_btn").hide();
      $("#eo-about").hide();
    <?php }
    ?>
  });
</script>
<!-- =================================== -->

<!-- upload profile image through Ajax ============== -->
<script>
$(document).ready(function(){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on('change','#eo-dp',function(e){
    if ($('#eo-dp').val()) {
      e.preventDefault()
      $('#loaderIcon').show()
      var user_id="{{$user->id}}";

      var image = $('.pf-image-change')[0].files[0];

      form = new FormData();
      form.append('profile-image',image);
      form.append('user_id',user_id);

      $.ajax({
        type: 'post',
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        url: "{{ url('imageUpload/'.$user->id) }}",
        success: function(response){
          console.log(response);
          if(response){

            $('.eo-c-logo').attr('src','<?= url('img/profile')?>/'+response);
            $('#loaderIcon').hide();
          }else {
            toastr.error('Following format allowed (PNG/JPG/JPEG)', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
          }

        }
      });
    }
  });
});
</script>

<!-- ============================================ -->
<!-- Cover image using Ajax===================================== -->

<script>
$(document).ready(function () {
  $.ajaxSetup({
    header: {
      'X-CSRF-TOKEN' : $('meta[name="csrf_token"]').attr('content')
    }
  });
  $(document).on("change", "#cover", function (e) {
    if ($('#cover').val()) {
      e.preventDefault()
      $('#loaderIcon').show()
      var id = "{{$user->id}}";
      var image = $('.sp-cover')[0].files[0];

      form = new FormData();
      form.append('cover_image', image);
      form.append('user_id', id);

      $.ajax({
        type: 'post',
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        url: "{{ url('coverUpload/'. $user->id) }}",
        success: function (response) {
          console.log(response);
          // alert(response);
          if(response) {
            $('#loaderIcon').hide()
            $('.eo-timeline-cover').attr('src','<?=url('img/cover')?>/'+response);
          }
        }
      });
    }
  });
});
// ================================To remove profile picture  ==========================

function editcompanypic(){
  var proImg = $('.eo-dp').attr('src');
  $('#editProCompanyModel').modal('show');
  $('#proEditImg img').attr('src',proImg);
  $('#proEditImg img').rcrop({
    minSize : [100,100],
    preserveAspectRatio : true,

    preview : {
      display: true,
      size : [100,100],
      wrapper : '#custom-preview-wrapper'
    }
  });

}
$('#proEditImg img').on('rcrop-changed', function(){
  var srcOriginal = $(this).rcrop('getDataURL');
  var srcResized = $(this).rcrop('getDataURL', 50,50);
  var userId = "{{ session()->get('ses') }}";
  $('.eo-dp').attr('src',srcOriginal);
  //test:
  var blob = dataURLtoBlob(srcOriginal);
  var imagelink = $('#proEditImg img').attr('src');

  /*blobToDataURL(blob, function(dataurl){
  console.log(dataurl);
});*/
var fd = new FormData();
fd.append('profileImage', blob);
fd.append('_token', "{{ csrf_token() }}");
fd.append('userId', userId);
fd.append('imagelink', imagelink);
$.ajax({
  type: 'POST',
  url: '{{ url("cropCompanyProfileImage") }}',
  data: fd,
  processData: false,
  contentType: false
}).done(function(data) {
  console.log(data);
});
});
// ===================== To remove profile image =======================
function removecompanypic(){
  var userId = $('#userID').val();
  $.ajax({
    url:'{{ url("RemCompProImage") }}',
    data:{userId:userId,_token:'{{ csrf_token() }}'},
    type:'POST',
    success:function(res){
      if(res == 1){
        toastr.success('home.Profile Pic Remove');
        $('.eo-dp').attr('src','{{ asset("compnay-logo/default-logo.jpg") }}');
      }
    }
  });
}



function new_hire(id) {
  console.log(id);
      var _token = $("input[name='_token']").val();
      var name = $('#user_name').val();
      var email = $('#user_email').val();
      var phone = $('#user_phone').val();
      var issue = $('#user_issue').val();
      var provider_id = id;

      console.log(name);
      form = new FormData();
      form.append('name', name);
      form.append('email', email);
      form.append('phone', phone);
      form.append('issue', issue);
      form.append('_token', _token);
      form.append('provider_id', provider_id);

      $.ajax({
        type: 'post',
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        url: "{{url('/user/hiring')}}",
        success: function (response) {
          console.log(response);
          // alert(response);
          if(response ==  1) {
            $('#myModal'+provider_id).modal('hide');
            // $('#myModal'+provider_id).hide();
            // $('#myModal'+provider_id).fadeOut();

          }
        }
      });

}


</script>

@endsection
