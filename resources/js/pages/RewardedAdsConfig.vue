<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="[
            'my apps',
            'maindashboard',
            'advertisement',
            'rewarded',
            'configure',
        ]"
        whose="app"
    ></BreadCrumb>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
            <SuccessMessage
                v-if="success_msg"
                :success_msg="success_msg"
            ></SuccessMessage>
            <div class="card box-shadow-0">
                <div class="card-body pt-0">
                    <form>
                        <div class="form-group" bis_skin_checked="1">
                            <label
                                class="custom-control custom-checkbox custom-control-md"
                            >
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="add_status"
                                    value="1"
                                    :checked="
                                        form_data.add_status ? 'checked' : ''
                                    "
                                    v-model="form_data.add_status"
                                />
                                <span
                                    class="custom-control-label custom-control-label-sm tx-14"
                                    >Tick the box to enable displaying
                                    advertisements on the app.</span
                                >
                            </label>
                        </div>
                        <div
                            class="form-group rageselecttor"
                            bis_skin_checked="1"
                        >
                            <label>Viewable Rate</label
                            ><i
                                class="fa fa-question-circle trigger"
                                style="cursor: pointer; margin-left: 10px"
                                id="tt"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="The viewable rate of an advertisement represents the percentage of times the ad will be viewed by the client, indicating the level of visibility and potential exposure to the intended audience."
                                data-bs-original-title=""
                            ></i>
                            <div class="slider-wrap">
                                <div class="labels">
                                    <span class="label-box">1</span>

                                    <span
                                        class="active-value"
                                        :style="{ left: bubbleLeft }"
                                    >
                                        {{ form_data.viewable_rate }}
                                    </span>

                                    <span class="label-box">10</span>
                                </div>

                                <div class="range-box">
                                    <div class="range-track">
                                        <div
                                            :class="
                                                form_data.viewable_rate > 4
                                                    ? 'range-progress'
                                                    : 'range-downgrade'
                                            "
                                            :style="{ width: progressWidth }"
                                        ></div>
                                    </div>

                                    <input
                                        type="range"
                                        min="1"
                                        max="10"
                                        v-model="form_data.viewable_rate"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <input type="hidden" name="saveconfiguration" />
                            <button
                                type="button"
                                id="saveconfiguration-btn"
                                :class="[
                                    'btn btn-primary',
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
import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";

export default {
    name: "RewardedAdsConfig",
    components: {
        BreadCrumb,
        SuccessMessage,
    },
    data() {
        return {
            form_data: {
                id: "",
                add_type: "rewarded",
                add_status: 0,
                viewable_rate: 1,
            },
            success_msg: "",
            disabled: false,
        };
    },
    computed: {
        sliderPercent() {
            const min = 1;
            const max = 10;
            const value = Number(this.form_data.viewable_rate);
            return ((value - min) / (max - min)) * 100;
        },

        progressWidth() {
            return this.sliderPercent + "%";
        },

        bubbleLeft() {
            return `calc(${this.sliderPercent}% + (${8 - this.sliderPercent * 0.16}px))`;
        },
    },

    methods: {
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            if (this.form_data.viewable_rate < 5) {
                this.disabled = false;
                Swal.fire({
                    title: "Are you referring to saving the rate at which the advertisement is viewed or the measurement of viewability ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return false;
                    }else{
                        this.disabled = true;
                        this.saveConfuguration();
                    }
                });
            }else{
                this.saveConfuguration();
            }
        },

        saveConfuguration() {
            axios
                .post("/admin/rewarded-ads-configure", this.form_data)
                .then((res) => {
                    this.disabled = false;
                    this.success_msg = res.data.msg;
                });
        },
    },
    mounted() {
        axios
            .post("/admin/rewarded-ads-configure-data", {
                id: this.form_data.id,
            })
            .then((res) => {
                this.form_data.add_type = res.data.configurations.add_type;
                this.form_data.add_status = res.data.configurations.add_status == 1 ? true : false;
                this.form_data.viewable_rate = res.data.configurations.viewable_rate;
            });
    },
};
</script>
<style scoped>
body {
    font-family: Arial, sans-serif;
    background: #fff;
    padding: 40px;
}

.slider-wrap {
    width: 520px;
    position: relative;
}

.labels {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 12px;
    color: #8f96a3;
    position: relative;
}

.label-box {
    background: #f3f4f6;
    color: #9aa0aa;
    padding: 3px 7px;
    border-radius: 6px;
    line-height: 1;
    font-weight: 500;
}

.active-value {
    position: absolute;
    top: -2px;
    transform: translateX(-50%);
    background: #39d6c1;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 6px;
    line-height: 1;
    pointer-events: none;
    transition: left 0.1s ease;
}

.range-box {
    position: relative;
    height: 24px;
    display: flex;
    align-items: center;
}

.range-track {
    position: absolute;
    width: 100%;
    height: 4px;
    background: #d9dbe3;
    border-radius: 999px;
    overflow: hidden;
}

.range-progress {
    position: absolute;
    height: 100%;
    width: 0%;
    background: #39d6c1;
    border-radius: 999px;
}

.range-downgrade {
    position: absolute;
    height: 100%;
    width: 0%;
    background: #f34343;
    border-radius: 999px;
}

input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    background: transparent;
    position: relative;
    margin: 0;
    z-index: 2;
}

input[type="range"]::-webkit-slider-runnable-track {
    height: 4px;
    background: transparent;
}

input[type="range"]::-moz-range-track {
    height: 4px;
    background: transparent;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 14px;
    height: 20px;
    border-radius: 6px;
    background: #fff;
    border: 2px solid #39d6c1;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    margin-top: -8px;
}

input[type="range"]::-moz-range-thumb {
    width: 14px;
    height: 20px;
    border-radius: 6px;
    background: #fff;
    border: 2px solid #39d6c1;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
    cursor: pointer;
}
</style>
