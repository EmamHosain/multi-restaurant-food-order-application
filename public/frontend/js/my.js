$.ajax({
            url: '{{ route("cart.updateQuantity") }}',
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               id: id,
               quantity: quantity
            },
            success: function(response){
               Toast.fire({
                  icon: 'success',
                  title: 'Quantity Updated'
               }).then(() => {
                  location.reload();
               });

            }
         })





          $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               id: id
            },
            success: function(response){

               Toast.fire({
                  icon: 'success',
                  title: 'Cart Remove Successfully'
               }).then(() => {
                  location.reload();
               });

            }
         });