@extends('user.layout_two')
    @section('layout_two_section')





  <div class="card">
    <div class="card-body login-card-body">
@if(Session::has('message'))
<p class="alert alert-danger">{{ Session::get('message') }}</p>
@else
<p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

@endif


      <form  id="password_reset" >
          @csrf
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="password_reset_btn">Change password</button>
          </div>
          <!-- /.col -->
        </div>
        <input type="hidden" name="email"  value="{{ $email }}">
        <input type="hidden" name="str"  value="{{ $str }}">

      </form>

      <p class="mt-3 mb-1">
        <a href="{{ url('login') }}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


@push('layout_two_scripts')



<script>



    $("#password_reset").submit(function(e) {
      e.preventDefault();
      $('#password_reset_btn').prop('disabled', true);

      var page_load = `<div class="overlay-wrapper">
          <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
        </div>`
        $('.pageloader').html(page_load)

      var password_reset_from = new FormData($(this)[0])
      $.ajax({
          type: "post",
          Headers: {
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          },
          url: '/reset-password-submit',
          data: password_reset_from,
          success: function(data) {
              if (data.success){

                  toastr.success(data.success)
                   setTimeout(function(){
                    window.location.href='/login'
                 }, 2000);

              }else{
                  $('.pageloader').html(' ')
                  $('#password_reset_btn').prop('disabled', false);
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
