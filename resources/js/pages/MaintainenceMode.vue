<template>
	<!-- breadcrumb -->
	<BreadCrumb
		:crumb_data="[
			'my apps',
			'#' + whmcs_service_id + ' ' + app_name,
			'maindashboard',
			'maintainencemode',
		]"
		whose="app"
	></BreadCrumb>
	<!-- /breadcrumb -->
	<!-- row -->
	<div class="row">
		<div class="col-md-8">
			<SuccessMessage
				v-if="success_msg"
				:success_msg="success_msg"
			></SuccessMessage>
			<div class="card box-shadow-0 mt-5 pt-20">
				<div class="card-body pt-0">
					<form>
						<div class="form-group">
							<label>
								<input
									type="checkbox"
									v-model="form_data.status"
									:checked="form_data.status"
								/>
								Tick to put an app on maintainence mode
							</label>
						</div>
						<div class="form-group">
							<label>Maintainence mode message</label>
							<textarea
								type="text"
								:class="[
									'form-control',
									{ 'border-danger': message_error },
								]"
								v-model="form_data.message"
							>
							</textarea>
							<span class="text-danger" v-show="message_error">{{
								message_error
							}}</span>
						</div>
						<div class="form-group">
							<button
								type="submit"
								:class="[
									'btn btn-primary mt-3 mb-0',
									{ disabled: disabled },
								]"
								v-on:click="submit($event)"
							>
								{{ !disabled ? "Save" : "Please wait..." }}
							</button>
						</div>
					</form>
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
	name: "DnsManage",
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
				status: false,
				maintainence_mode_message: "",
			},
			message_error: "",
			disabled: false,
			success_msg: "",
		};
	},
	methods: {
		submit(e) {
			e.preventDefault();
			this.disabled = true;
			this.message_error = "";
			axios
				.post("/admin/maintainence-mode-manage", this.form_data)
				.then((res) => {
					this.disabled = false;
					if (res.data.errors) {
						if (res.data.msg.message) {
							this.message_error = res.data.msg.message[0];
						}
					} else {
						this.success_msg = res.data.msg;
					}
				});
		},
	},
	mounted() {
		const auth = useAuthStore();
		this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
		this.app_name = auth.appDetail ? auth.appDetail.title : null;

		axios.post("/admin/maintainence-mode-status").then((res) => {
			this.form_data.id = res.data?.id;
			this.form_data.status = res.data?.status == "on" ? true : false;
			this.form_data.message = res.data?.msg;
		});
	},
};
</script>
<style scoped>
.pt-20 {
	padding-top: 20px;
}
</style>
