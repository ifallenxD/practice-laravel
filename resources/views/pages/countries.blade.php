<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- bootstrap --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

        <title>Demo 1 App</title>
        <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
     
        {{-- contents will go here --}}

        
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/">Home</a>
            </nav>
            <hr>
            <div class="main-content">

                {{-- livewire components will be rendered here --}}

                @livewire('countries')
                @livewire('states')
            </div>
        </div>
        
        {{-- ... Other meta tags and styles ... --}}
        {{-- bootstrap js --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
         {{-- sweetalert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- sweetalert2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            

            $(document).ready(function () {
                $(window).on('closeModal', function(event) {
                    $('#' + event.detail).modal('hide');
                });
                $(window).on('openModal', function(event) {
                    $('#' + event.detail).modal('show');
                });
            });


            //prepare toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

                //fire toast on alert event
            window.addEventListener('alert', (event) => {

                const eventData = event.detail;
                const type = eventData[0].type;
                const message = eventData[0].message;

                Toast.fire({
                    icon: type,
                    title: message
                })
            });


            //open a confirm dialog on confirmDelete event
            window.addEventListener('confirmDelete', (event) => {

                //event data (id, and deleteProductEvent)
                const eventData = event.detail;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.Livewire.dispatch(eventData.targetEvent, {id:eventData.id});
                    }
                })

            });
        </script>
    </body>
</html>