<template>
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<BreadCrumb
			:crumb_data="[
				'My Apps',
				'#' + whmcs_service_id + ' ' + app_name,
				'App Storage Preference',
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
			<div class="card box-shadow-0 pt-3">
				<div class="card-body pt-0">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="mb-3"
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
												class="custom-control-input"
												name="mode"
												value="local"
												v-model="form_data.mode"
												:checked="
													form_data.mode == 'local'
												"
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
												class="custom-control-input"
												name="mode"
												value="cloud"
												v-model="form_data.mode"
												:checked="
													form_data.mode == 'cloud'
												"
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
									type="submit"
									:class="[
										'btn btn-primary mt-3 mb-0',
										{ disabled: disabled },
									]"
									v-on:click="submit($event)"
								>
									{{
										!disabled ? "Submit" : "Please wait..."
									}}
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
				mode: "cloud",
			},

			disabled: false,
			success_msg: "",
		};
	},
	methods: {
		submit(e) {
			e.preventDefault();
			this.disabled = true;

			axios
				.post("/admin/app-storage-preference-manage", this.form_data)
				.then((res) => {
					this.disabled = false;
					this.success_msg = res.data.msg;
				});
		},
	},
	mounted() {
		const auth = useAuthStore();
		this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
		this.app_name = auth.appDetail ? auth.appDetail.title : null;

		axios.post("/admin/app-storage-preference-status").then((res) => {
			this.form_data.id = res?.data?.record?.id;
			this.form_data.mode = res?.data?.record?.mode;
		});
	},
};
</script>
