<template>
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<BreadCrumb
			:crumb_data="[
				'my apps',
				'#' + whmcs_service_id + ' ' + app_name,
				'app storage preference',
			]"
			whose="app"
		></BreadCrumb>
	</div>
	<!-- /breadcrumb -->
	<!-- row -->
	<div class="row">
		<div class="col-md-8">
			<SuccessMessage
				v-if="success_msg"
				:success_msg="success_msg"
			></SuccessMessage>
			<div class="card box-shadow-0 pt-5">
				<div class="card-body pt-0">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputSMTPPort"
									><b
										>Choose where to save your Favorites,
										Recently Watched, and Continue Watching
										for Syncing:</b
									></label
								>
								<fieldset>
									<div class="some-class">
										<label
											class="custom-control custom-radio"
										>
											<input
												type="radio"
												class="custom-control-input common_typese"
												name="preferencetype"
												value="0"
												checked=""
											/>
											<span class="custom-control-label"
												><b>Local Storage:</b> Save
												content directly to your
												device's local storage. This
												option stores your data only on
												your phone or mobile
												device.</span
											>
										</label>

										<label
											class="custom-control custom-radio"
										>
											<input
												type="radio"
												class="custom-control-input common_typese"
												name="preferencetype"
												value="1"
											/>
											<span class="custom-control-label"
												><b>Cloud Storage:</b> Sync your
												content across all your
												logged-in devices using your
												configured Firebase account.
												Favorites, Recently Watched, and
												Continue Watching will stay
												up-to-date across all devices.
												(New Feature).</span
											>
										</label>
									</div>
								</fieldset>
							</div>
							<div class="form-group mt-3">
								<input
									type="hidden"
									name="actiontoperform"
									value="savestoragepreferences"
								/>
								<button
									type="button"
									id="savepreferences"
									value="savestoragepreferences"
									class="btn custombuttonspaces btn-primary custommr"
								>
									Save Changes
								</button>
							</div>

							<div style="display: none">
								<label>Fill This Field</label
								><input type="text" name="honeypot" value="" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- row closed -->
</template>
<script>
import axios from "axios";
import { useMessageStore } from "../stores/messageStore";
import { useAuthStore } from "@/stores/auth";
import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";

export default {
	name: "AppManage",
	components: {
		BreadCrumb,
		SuccessMessage,
	},
	data() {
		return {
			whmcs_service_id: "",
			app_name: "",

			form_data: {
				id: "",
				mode: "",
			},

			disabled: false,
			success_msg: "",
		};
	},
	methods: {
		submit(e) {
			e.preventDefault();
			this.disabled = true;
			this.app_name_error = "";
			this.app_type_error = "";
			axios.post("/admin/app-manage", this.form_data).then((res) => {
				this.disabled = false;
				if (res.data.errors) {
					if (res.data.msg.app_name) {
						this.app_name_error = res.data.msg.app_name[0];
					}
					if (res.data.msg.app_type) {
						this.app_type_error = res.data.msg.app_type[0];
					}
				} else {
					if (!this.form_data.id) {
						const success = useMessageStore();
						success.setMessage(res.data.msg);
						this.$router.push({ name: "app-list" });
					} else {
						this.success_msg = res.data.msg;
					}
				}
			});
		},
	},
	mounted() {
		const auth = useAuthStore();
		this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
		this.app_name = auth.appDetail ? auth.appDetail.title : null;

		// axios
		// 	.post("/admin/app-edit", {
		// 		id: this.form_data.id,
		// 	})
		// 	.then((res) => {
		// 		this.form_data.id = res.data.record.id;
		// 		this.form_data.app_name = res.data.record.title;
		// 		this.form_data.app_type = res.data.record.type;
		// 	});
	},
};
</script>
