<script>

  $(document).ready(function(){

   $("#imagen").imagepicker()
   
    $('.input-img').click(function(){

      {{-- Carga dinámica de las imagenes de cupones y promociones --}}
      @if(isset($data['cupon']) && $data['cupon']->imagen )

        var imagen = '{!! $data['cupon']->imagen !!}';

      @else

        var imagen = '';

      @endif

      $('#elementos-img').addClass('hidden')
      $('#contenedor-imagen').removeClass('hidden')
      $('.fa-spinner').removeClass('hidden')

        var categoria_slug = $(this).data('categoria_slug');
        var url_imagenes = 'cupones';
        
        $.post( "{{ route('imagenes_por_categoria') }}", { categoria_slug: categoria_slug, imagen_marcada: imagen, url_imagenes: url_imagenes })
          .done(function(data) {

            $('.fa-spinner').addClass('hidden')
            $('#elementos-img').removeClass('hidden')
            $('#elementos-img').html(data)
            $("#imagen").imagepicker()
        })
          .fail(function() {
            $('.fa-spinner').addClass('hidden')
            $('#elementos-img').html('No hemos podido cargar las imágenes, por favor, vuelva a intentarlo')
        });
    });
  });
	
</script>