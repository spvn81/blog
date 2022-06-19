
@extends('user.layout_two')
    @section('layout_two_section')

        <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form  id="user_login">
                @csrf

              <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember_me">
                    <label for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" id="user_login_btn" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>



            <p class="mb-1">
              <a href="{{ url('forgot-password') }}">I forgot my password</a>
            </p>

          </div>
          <!-- /.login-card-body -->
        </div>


        @push('layout_two_scripts')
        <script>



      $("#user_login").submit(function(e) {
        e.preventDefault();
        $('#user_login_btn').prop('disabled', true);

        var page_load = `<div class="overlay-wrapper">
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
          </div>`
          $('.pageloader').html(page_load)

        var user_regireter_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            },
            url: '/auth',
            data: user_regireter_form,
            success: function(data) {
                if (data.success){

                    toastr.success(data.success)
                     setTimeout(function(){
                    location.reload();
                   }, 2000);

                }else{
                    $('.pageloader').html(' ')
                    $('#user_login_btn').prop('disabled', false);
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
