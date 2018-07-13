
var map;
var myLatlng;
var radius;
var lngval;
var latval;
var kilometer =$("input[name='people_show']").val();
if (kilometer == null) {
    kilometer = 3;
}else {
  kilometer = 300;
}
// alert(kilometer);
var km =  (1/111)*kilometer;
// alert(km);
var autozoom;
// var km =  0.04504504;
var api_url='http://127.0.0.1:8000/api/'

$("#area_btn").click(function () {
  kilometer = kilometer * 2;
  km =  (1/111)*kilometer;
  skills();
});

$("#gskill").click(function () {
var skill = $("#skill_val").val();
skills(skill);
});
var rec_skill =$("input[name='skill_send']").val();
skills(rec_skill);
$("#area_btn_skill").click(function () {
var rec_skill =$("input[name='skill_send']").val();
kilometer = kilometer * 2;
km =  (1/111)*kilometer;
skills(rec_skill);
});



  function skills(get_skill) {
    // alert(get_skill);
  geoLocationInit();
  function geoLocationInit() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(success, fail);
    }else {
      alert("Browser not supported");
    }
  }

  function success(position) {
    // console.log(position);
     latval = position.coords.latitude;
     lngval = position.coords.longitude;

     myLatlng = new google.maps.LatLng(latval, lngval);

    searchBoys(latval, lngval, km, get_skill);
  }

  function fail() {
    alert("It Fails");
  }
  //Create Map
  function createMap(myLatlng, autozoom) {
     map = new google.maps.Map(document.getElementById('map'), {
      center: myLatlng,
      zoom:autozoom

    });

    var marker = new google.maps.Marker({
          position: myLatlng,
          map: map
    });


  }

  //Create Marker
  function createMarker(latlng, icn, name) {

    var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: icn,
            title:name
            // draggable: true

        });
  }

function searchBoys(lat, lng, km, get_skill) {

  // alert(get_skill);
      var mydata={
        latitude:lat,
        longitude:lng,
        km: km,
        skill: get_skill

      }

$(document).ready(function(){
      $.ajaxSetup({
        header: {
          'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
      });

      // console.log(mydata);

      $.ajax({
        type: 'post',
        data: mydata,
        url: api_url+"searchBoys",
        success: function (response) {
          // console.log(response);
          if (response == "not found") {
            toastr.warning('No Record Found');
            window.location.href = "/";
          }

          var res = JSON.parse(response);
          // console.log(km);
          km = res.km;

        radius = km*111*1000+1000;
         var kilom=res.km*111;
            console.log(kilom);
        if(kilom <=10){
          autozoom=12;
        }
        else if (kilom <=20)
        {
          autozoom=11;
        } else if(kilom <=40)
        {
           autozoom=10;
        }
          else if(kilom <=80)
          { autozoom=8;
          }
          else if(kilom >200){
            autozoom=5;
          }

          console.log(autozoom);
          createMap(myLatlng,autozoom);
                                                 // Circle at Map
          var circle = new google.maps.Circle({
            map: map,
            center: myLatlng,
            radius: radius
          });
          $.each(res.provider, function (i, val) {
            // console.log(val.name);
            console.log(res.provider[i].name);
            if ((res.provider)== null) {
              window.location('home.blade.php');
            }
            // console.log(res.provider.);
          var  glatval=val.latitude;
          var  glngval=val.longitude;
          var  gname=val.name;

          var temp = '';
          for (var i = 0; i <res.provider.length; i++) {
            var profile_img = '';
            if (res.provider[i].image == null) {
            profile_img = '<img src="http://localhost:8000/img/profile-logo.jpg" class="pf-image" alt="">'
            // alert(profile_img);
            }
            else {

            profile_img = '<img src="http://localhost:8000/img/'+res.provider[i].image+'" class="pf-image" alt="">'
            // console.log(profile_img);
            }

            temp +='<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 profile_card_show">'+
            '<div class="well well-sm">'+
              '<div class="">'+
                     '<div class="col-sm-12 text-center">'+
                    '<div class="profile-show">'+
                    '<a href="http://localhost:8000/profile_view/'+res.provider[i].id+ '">'+ profile_img+ '</a>'+
                    // profile_img+
                    '</div>'+
                    '</div>'+
                  '<div class="col-sm-12 col-md-8">&nbsp;'+
                  '<h4><a href="http://localhost:8000/profile_view/'+res.provider[i].id+ '">'+  res.provider[i].name+ '</a></h4>'+
                      <!-- Split button -->
                      '<div class="row">'+
                        '<div class="col-md-12 col-sm-12 col-xm-12">'+
                         '<i class="fa fa-wrench"></i>&nbsp; &nbsp;'+
                    			res.provider[i].skill+

                       '</div>'+
                      '</div>'+

                      '<div class="row">'+
                       '<div class="col-md-12 col-sm-12 col-xm-12">'+
                        '<i class="fa fa-map-marker"></i>&nbsp;  &nbsp; '+
      	                         res.provider[i].location+
      	                        '</div>'+
      	                      '</div>'+
      	                    '</div>'+
      	                '</div>'+
      	            '</div>'+
      	        '</div>';
          }

          document.getElementById('show_all').innerHTML = temp;
          var  GLatlng = new google.maps.LatLng(glatval, glngval);
          var  gicn = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
            // alert(GLatlng);
            createMarker(GLatlng, gicn, gname);

          });
        }
      });
    });
    }
}
