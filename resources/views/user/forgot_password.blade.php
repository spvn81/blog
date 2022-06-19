@extends('user.layout_two')
    @section('layout_two_section')




        <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

            <form id="resetPassword" >
                @csrf
              <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" id="resetPassword_btn" class="btn btn-primary btn-block">Request new password</button>
                </div>
                <!-- /.col -->
              </div>
            </form>

            <p class="mt-3 mb-1">
              <a href="{{ url('/login') }}">Login</a>
            </p>

          </div>
          <!-- /.login-card-body -->
        </div>



        @push('layout_two_scripts')


        <script>



            $("#resetPassword").submit(function(e) {
              e.preventDefault();
              $('#resetPassword_btn').prop('disabled', true);

              var page_load = `<div class="overlay-wrapper">
                  <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
                </div>`
                $('.pageloader').html(page_load)

              var user_form = new FormData($(this)[0])
              $.ajax({
                  type: "post",
                  Headers: {
                      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                  },
                  url: '/send-otp',
                  data: user_form,
                  success: function(data) {
                      if (data.success){

                          toastr.success(data.success)
                           setTimeout(function(){
                          location.reload();
                         }, 2000);

                      }else{
                          $('.pageloader').html(' ')
                          $('#resetPassword_btn').prop('disabled', false);
                          $.each(data.errors,function(key,value){
                              toastr.error(value)
                          })

                      }

                  },

                  contentType: false,
                  processData: false,
                  cache: false,

              });
          })

              </script>





        @endpush

    @endsection



