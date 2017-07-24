    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="submenu-comercio">
                <ul class="submenu-item-list">
                    <a class="listado" href="{!! route('listar-cupones', Auth::user()->slug) !!}"><li>LISTADO DE MIS CUPONES</li></a>
                    <a class="creacion" href="{!! route('cupones.create') !!}"><li class="">NUEVO CUPÓN</li></a>
                    <a class="edicion" href=""><li></li></a>
                </ul>
                <div class="submenu-item-description">
                    <p class="listado hidden">EL listado de tus cupones te permite ver todo el histórico de cupones de tu comercio. Pincha en el cupón si quieres editarlo, duplicarlo o borrarlo.</p>

                    <p class="creacion hidden">Crea y genera cupones y ofertas para tu comercio fácilmente. Puedes generar todos los cupones que quieras. Selecciona el local al que se aplica la oferta o cupón y en qué categoría quieres que se ubique.</p>

                </div>
            </div>
        </div>
    </div>
