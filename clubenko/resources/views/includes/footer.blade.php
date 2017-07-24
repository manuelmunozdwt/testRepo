  <div id="footer" class="fixed">
    @section('footer-html')
      <div class="footer">footer</div>
    @show
  </div>
</div>
<!-- fin wrapper -->
    <!-- JavaScripts -->
  <script src="https://unpkg.com/jquery@3.2.1"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

  <script type="text/javascript" src="{!! asset('js/ajaxSetup.js') !!}"></script>

  <!-- CKEditor -->
  <script src="{!! asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') !!}"></script>
  <script src="{!! asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') !!}"></script>   
  <script src="{!! asset('vendor/unisharp/laravel-ckeditor/styles.js') !!}"></script>
  <script src="{!! asset('js/jquery.ezdz.js') !!}"></script>
  <script>
      $('textarea').ckeditor();
  </script>



  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="{!! asset('plugins/slick/slick.min.js') !!}"></script>


  <script type="text/javascript">
        $('.slider').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            prevArrow: '<span class="glyphicon glyphicon-menu-left flecha-izq"></span>',
            nextArrow:'<span class="glyphicon glyphicon-menu-right flecha-dch"></span>'
        });
      $('.slider').show();
  </script>

<script type="text/javascript">
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      //console.log(position.coords.latitude + '-'+position.coords.longitude);

    });

  } else {
   //consle.log('geolocation IS NOT available');
  }
</script>

<script type="text/javascript" src="{!! asset('js/bootstrap-notify.min.js') !!}"></script>
<!-- NOTIFY -->

@if (isset($errors))
  @if($errors->any())
    <script>
      $.notify({
      // options
      message: "{!! string_errors($errors) !!}"
    },{
      // settings
      delay: 3000,
    });

    </script>
  @endif
@endif

@if (isset($data['cupon']))
  <script>
      $(document).ready(function() {
         $('.like').click(function(){

          var id = ($(this).attr("id"));
          var descargas_cupon = "{{ $data['cupon']->likes }}"
            $.ajax({
            data: $(this).attr("id"),
            type: "GET",
            url: "{{route('like')}}",
            success: function(a) {
              var suma = parseInt(a[1]) + parseInt(descargas_cupon);
              $('#cont_'+a[2]+'_'+a[0]).html(suma + '  personas les gusta');
                    if (a[3]) {
                      $('#heart_'+a[2]+'_'+a[0]).html('<i class="fa fa-heart  m-r-10"></i>');
                    }
                    else{
                      $('#heart_'+a[2]+'_'+a[0]).html('<i class="fa fa-heart-o  m-r-10"></i>');
                    }
            }
             });
         });
      });
  </script>
@endif



<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDfG2Fej_lh3gaXBLiZqULBgw0-wlk54W0&callback=initMap&libraries=places" async defer></script>
 
@section('JSpage')
<script>
    var map;
    function initMap() {
    }
  </script>
@show
</body>
</html>
