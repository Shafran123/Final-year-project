<style type="text/css">
	@font-face {
	  font-family: Poppins-Regular;
	  src: url('../fonts/poppins/Poppins-Regular.ttf'); 
	}

	@font-face {
	  font-family: Poppins-Medium;
	  src: url('../fonts/poppins/Poppins-Medium.ttf'); 
	}

	@font-face {
	  font-family: Poppins-Bold;
	  src: url('../fonts/poppins/Poppins-Bold.ttf'); 
	}

	@font-face {
	  font-family: Poppins-SemiBold;
	  src: url('../fonts/poppins/Poppins-SemiBold.ttf'); 
	}
	.wrap-login100 {
	    width: 670px;
	    background: #fff;
	    border-radius: 10px;
	    overflow: hidden;
	    position: relative;
	}
	.login100-form-title {
	    width: 100%;
	    position: relative;
	    z-index: 1;
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -ms-flexbox;
	    display: flex;
	    flex-wrap: wrap;
	    flex-direction: column;
	    align-items: center;
	    background-repeat: no-repeat;
	    background-size: cover;
	    background-position: center;
	    padding: 70px 15px 74px 15px;
	}
	.login100-form-title::before {
	    content: "";
	    display: block;
	    position: absolute;
	    z-index: -1;
	    width: 100%;
	    height: 100%;
	    top: 0;
	    left: 0;
	    background-color: rgba(54,84,99,0.7);
	}

	.login100-form-title-1 {
	    font-family: Poppins-Bold;
	    font-size: 30px;
	    color: #fff;
	    text-transform: uppercase;
	    line-height: 1.2;
	    text-align: center;
	}

	.login100-form {
	    width: 100%;
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -ms-flexbox;
	    display: flex;
	    flex-wrap: wrap;
	    justify-content: space-between;
	    padding: 43px 88px 93px 190px;
	}
	.wrap-login100 .validate-input {
	    position: relative;
	}

	.wrap-input100 {
	    width: 100%;
	    position: relative;
	    border-bottom: 1px solid #b2b2b2;
	}
	.m-b-26 {
	    margin-bottom: 26px;
	}

	.label-input100 {
	    font-family: Poppins-Regular;
	    font-size: 15px;
	    color: #808080;
	    line-height: 1.2;
	    text-align: right;
	    position: absolute;
	    top: 14px;
	    left: -105px;
	    width: 80px;
	}

	.wrap-login100 input.input100 {
	    height: 45px;
	}
	.input100 {
	    font-family: Poppins-Regular;
	    font-size: 15px;
	    color: #555555;
	    line-height: 1.2;
	    display: block;
	    width: 100%;
	    background: transparent;
	    padding: 0 5px;
	}

	.wrap-login100 input {
	    outline: none;
	    border: none;
	}

	.focus-input100 {
	    position: absolute;
	    display: block;
	    width: 100%;
	    height: 100%;
	    top: 0;
	    left: 0;
	    pointer-events: none;
	}

	.focus-input100::before {
	    content: "";
	    display: block;
	    position: absolute;
	    bottom: -1px;
	    left: 0;
	    width: 0;
	    height: 1px;
	    -webkit-transition: all 0.6s;
	    -o-transition: all 0.6s;
	    -moz-transition: all 0.6s;
	    transition: all 0.6s;
	    background: #57b846;
	}

	.flex-sb-m {
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -moz-box;
	    display: -ms-flexbox;
	    display: flex;
	    justify-content: space-between;
	    -ms-align-items: center;
	    align-items: center;
	}

	.w-full {
	    width: 100%;
	}
	.p-b-30 {
	    padding-bottom: 30px;
	}

	.m-b-18 {
	    margin-bottom: 18px;
	}
	input[type=checkbox], input[type=radio] {
	    box-sizing: border-box;
	    padding: 0;
	}

	.input-checkbox100 {
	    display: none;
	}
	input {
	    outline: none;
	    border: none;
	}

	.label-checkbox100 {
	    font-family: Poppins-Regular;
	    font-size: 13px;
	    color: #999999;
	    line-height: 1.4;
	    display: block;
	    position: relative;
	    padding-left: 26px;
	    cursor: pointer;
	}
</style>

<div class="wrap-login100">
	<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
		<span class="login100-form-title-1">
			Sign In
		</span>
	</div>

	<form class="login100-form validate-form">
		<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
			<span class="label-input100">Username</span>
			<input class="input100" type="text" name="username" placeholder="Enter username">
			<span class="focus-input100"></span>
		</div>

		<div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
			<span class="label-input100">Password</span>
			<input class="input100" type="password" name="pass" placeholder="Enter password">
			<span class="focus-input100"></span>
		</div>

		<div class="flex-sb-m w-full p-b-30">
			<div class="contact100-form-checkbox">
				<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
				<label class="label-checkbox100" for="ckb1">
					Remember me
				</label>
			</div>

			<div>
				<a href="#" class="txt1">
					Forgot Password?
				</a>
			</div>
		</div>

		<div class="container-login100-form-btn">
			<button class="login100-form-btn">
				Login
			</button>
		</div>
	</form>
</div>