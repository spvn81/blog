@extends('user.layout_two')
    @section('layout_two_section')

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Verify Email</p>

      <form id="verify_form">
        @csrf
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="otp" name="otp">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <input type="hidden" name="str" value="{{ $str }}">
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="hidden" name="otp_type" value="{{ $otp_type }}">



        <div class="row">
          <div class="col-12">
            <button type="submit" id="verifyotp" class="btn btn-primary btn-block">Verify</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ url('login') }}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>

  @push('layout_two_scripts')
  <script>


    $("#verify_form").submit(function(e) {
        e.preventDefault();
        $('#verifyotp').prop('disabled', true);

        var page_load = `<div class="overlay-wrapper">
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
          </div>`
          $('.pageloader').html(page_load)

        var verify_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            },
            url: '/verified/'+"{{ $str }}",
            data: verify_form,
            success: function(data) {
                if (data.success){
                    toastr.success(data.success)

                    setTimeout(function(){
                        window.location.href = '/login'
                    },2000)



                }else{
                    $('.pageloader').html(' ')
                    $('#verifyotp').prop('disabled', false);
                    toastr.error(data.errors)


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
