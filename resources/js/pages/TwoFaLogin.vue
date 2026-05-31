<template>
	<div class="square-box">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
	<div class="page">
		<div class="page-single">
			<div class="container">
				<div class="row">
					<div
						class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center"
					>
						<a href="javascript:;">
							<div
								data-v-c7378482=""
								class="display-2 primary--text"
								bis_skin_checked="1"
							>
								SBP Panel
							</div>
						</a>
						<div class="card-sigin">
							<!-- Demo content-->
							<div class="main-card-signin d-md-flex">
								<div class="wd-100p">
									<div class="">
										<div class="main-signup-header">
											<div class="panel panel-primary">
												<div
													class="panel-body tabs-menu-body border-0 p-3"
												>
													<div class="tab-content">
														<div
															class="tab-pane active"
															id="tab5"
														>
															<form action="#">
																<div
																	class="form-group"
																	v-if="
																		login_with_2fa
																	"
																>
																	<label
																		>Enter
																		2FA
																		Code</label
																	>
																	<input
																		:class="[
																			'form-control',
																			{
																				'border-danger':
																					code_error,
																			},
																		]"
																		v-model="
																			form_data.twofa_code
																		"
																		placeholder="Enter 2FA Code"
																		:type="
																			text_type
																		"
																	/>
																	<i
																		class="far fa-eye"
																		id="togglePassword"
																		style="
																			cursor: pointer;
																		"
																		v-on:click="
																			togglePassword
																		"
																	></i>
																</div>
																<div
																	class="form-group"
																	v-if="
																		!login_with_2fa
																	"
																>
																	<label
																		>Enter
																		Backup
																		Code</label
																	>
																	<input
																		:class="[
																			'form-control',
																			{
																				'border-danger':
																					code_error,
																			},
																		]"
																		v-model="
																			form_data.backup_code
																		"
																		placeholder="Enter Backup Code"
																		:type="
																			text_type
																		"
																	/>
																	<i
																		class="far fa-eye"
																		id="togglePassword"
																		style="
																			cursor: pointer;
																		"
																		v-on:click="
																			togglePassword
																		"
																	></i>
																</div>
																<span
																	class="text-danger"
																	>{{
																		code_error
																	}}</span
																>
																<p
																	class="text-center"
																>
																	Lost device?
																	Use backup
																	code to
																	regain
																	access
																</p>
																<div
																	class="text-center mb-3"
																>
																	<a
																		href="javascript:;"
																		v-on:click="
																			login_with_2fa =
																				!login_with_2fa
																		"
																		class="text-primary"
																		style="
																			cursor: pointer;
																		"
																		>Enter
																		Backup
																		Code</a
																	>
																</div>
																<button
																	class="btn btn-primary btn-block"
																	v-on:click="
																		submit(
																			$event,
																		)
																	"
																>
																	{{
																		disabled
																			? "Please wait..."
																			: "Verify"
																	}}
																</button>
																<button
																	class="btn btn-info btn-block"
																>
																	Back
																</button>
															</form>
														</div>
													</div>
												</div>
											</div>

											<div
												class="main-signin-footer text-center mt-3"
											></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import { useAuthStore } from "../stores/auth";
export default {
	name: "Login",
	data() {
		return {
			form_data: {
				twofa_code: "",
				backup_code: "",
			},
			login_with_2fa: true,
			text_type: "password",
			code_error: "",
			disabled: false,
			success_msg: "",
		};
	},
	methods: {
		togglePassword() {
			if (this.text_type === "password") {
				this.text_type = "text";
			} else {
				this.text_type = "password";
			}
		},
		submit(e) {
			e.preventDefault();
			let url =
				this.twofa_code != ""
					? "admin/2fa-verify-login"
					: "admin/2fa-verify-backup-code";
			let code =
				this.twofa_code != ""
					? this.form_data.twofa_code
					: this.form_data.backup_code;

			this.disabled = true;
			axios
				.post(url, {
					otp: code,
				})
				.then((res) => {
					this.disabled = false;
					if (res.data.errors) {
						if (res.data.msg.otp) {
							this.code_error = res.data.msg.otp[0];
						}
					} else {
						const auth = useAuthStore();
						auth.userDetail = res.data.user;
						this.$router.push({ name: "app-list" });
					}
				});
		},
	},
};
</script>
<style scoped>
.display-2 {
	font-size: 3.5rem;
	font-weight: 400;
	line-height: 1.2;
	color: #fff;
	margin-bottom: 15px;
	margin-top: -20px;
	margin-left: 114px;
}

#togglePassword {
	position: absolute;
	right: 25px;
	margin-top: -27px;
	font-size: 15px;
}
</style>
