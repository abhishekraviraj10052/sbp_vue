<template>
    <div class="main-header side-header sticky nav nav-item">
        <div class="main-container container-fluid">
            <div class="main-header-left">
                <div class="responsive-logo">
                    <a href="index.html" class="header-logo">
                        <img
                            src="../../assets/img/brand/logo.png"
                            class="mobile-logo logo-1"
                            alt="logo"
                        />
                        <img
                            src="../../assets/img/brand/logo-white.png"
                            class="mobile-logo dark-logo-1"
                            alt="logo"
                        />
                    </a>
                </div>
                <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                    <a class="open-toggle" href="javascript:void(0);"
                        ><i class="header-icon fe fe-align-left"></i
                    ></a>
                    <a class="close-toggle" href="javascript:void(0);"
                        ><i class="header-icon fe fe-x"></i
                    ></a>
                </div>

                <div class="logo-horizontal">
                    <a href="index.html" class="header-logo">
                        <img
                            src="../../assets/img/brand/logo.png"
                            class="mobile-logo logo-1"
                            alt="logo"
                        />
                        <img
                            src="../../assets/img/brand/logo-white.png"
                            class="mobile-logo dark-logo-1"
                            alt="logo"
                        />
                    </a>
                </div>
                <h4
                    v-if="
                        $route.name != 'app-list' && $route.name != 'app-manage'
                    "
                >
                    #{{ whmcs_service_id }}&nbsp{{ app_name }}
                </h4>
            </div>
            <div class="main-header-right">
                <button
                    class="navbar-toggler navresponsive-toggler d-lg-none ms-auto"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span
                        class="navbar-toggler-icon fe fe-more-vertical"
                    ></span>
                </button>
                <div
                    class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0"
                >
                    <div
                        class="collapse navbar-collapse"
                        id="navbarSupportedContent-4"
                    >
                        <ul
                            class="nav nav-item header-icons navbar-nav-right ms-auto"
                        >
                            <li class="dropdown nav-item">
                                <a
                                    class="new nav-link theme-layout nav-link-bg layout-setting"
                                >
                                    <span class="dark-layout"
                                        ><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="header-icon-svgs"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"
                                            /></svg
                                    ></span>
                                    <span class="light-layout"
                                        ><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="header-icon-svgs"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"
                                            /></svg
                                    ></span>
                                </a>
                            </li>

                            <li class="dropdown nav-item main-header-message">
                                <a
                                    class="new nav-link"
                                    data-bs-toggle="dropdown"
                                    href="javascript:void(0);"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="header-icon-svgs"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"
                                        />
                                    </svg>
                                    <span
                                        class="badge bg-secondary header-badge"
                                        >5</span
                                    >
                                </a>
                                <div class="dropdown-menu">
                                    <div
                                        class="menu-header-content text-start border-bottom"
                                    >
                                        <div class="d-flex">
                                            <h6
                                                class="dropdown-title mb-1 tx-15 font-weight-semibold"
                                            >
                                                Messages
                                            </h6>
                                            <span
                                                class="badge badge-pill badge-warning ms-auto my-auto float-end"
                                                >Mark All Read</span
                                            >
                                        </div>
                                        <p
                                            class="dropdown-title-text subtext mb-0 op-6 pb-0 tx-12"
                                        >
                                            You have 4 unread messages
                                        </p>
                                    </div>
                                    <div class="main-message-list chat-scroll">
                                        <a
                                            href="chat.html"
                                            class="dropdown-item d-flex border-bottom"
                                        >
                                            <div
                                                class="drop-img cover-image"
                                                data-image-src="../../assets/img/faces/3.jpg"
                                            >
                                                <span
                                                    class="avatar-status bg-teal"
                                                ></span>
                                            </div>
                                            <div class="wd-90p">
                                                <div class="d-flex">
                                                    <h5 class="mb-0 name">
                                                        Teri Dactyl
                                                    </h5>
                                                </div>
                                                <p class="mb-0 desc">
                                                    I'm sorry but i'm not sure
                                                    how to help you with
                                                    that......
                                                </p>
                                                <p
                                                    class="time mb-0 text-start float-start ms-2 mt-2"
                                                >
                                                    Mar 15 3:55 PM
                                                </p>
                                            </div>
                                        </a>
                                        <a
                                            href="chat.html"
                                            class="dropdown-item d-flex border-bottom"
                                        >
                                            <div
                                                class="drop-img cover-image"
                                                data-image-src="../../assets/img/faces/2.jpg"
                                            >
                                                <span
                                                    class="avatar-status bg-teal"
                                                ></span>
                                            </div>
                                            <div class="wd-90p">
                                                <div class="d-flex">
                                                    <h5 class="mb-0 name">
                                                        Allie Grater
                                                    </h5>
                                                </div>
                                                <p class="mb-0 desc">
                                                    All set ! Now, time to get
                                                    to you now......
                                                </p>
                                                <p
                                                    class="time mb-0 text-start float-start ms-2 mt-2"
                                                >
                                                    Mar 06 01:12 AM
                                                </p>
                                            </div>
                                        </a>
                                        <a
                                            href="chat.html"
                                            class="dropdown-item d-flex border-bottom"
                                        >
                                            <div
                                                class="drop-img cover-image"
                                                data-image-src="../../assets/img/faces/9.jpg"
                                            >
                                                <span
                                                    class="avatar-status bg-teal"
                                                ></span>
                                            </div>
                                            <div class="wd-90p">
                                                <div class="d-flex">
                                                    <h5 class="mb-0 name">
                                                        Aida Bugg
                                                    </h5>
                                                </div>
                                                <p class="mb-0 desc">
                                                    Are you ready to pickup your
                                                    Delivery...
                                                </p>
                                                <p
                                                    class="time mb-0 text-start float-start ms-2 mt-2"
                                                >
                                                    Feb 25 10:35 AM
                                                </p>
                                            </div>
                                        </a>
                                        <a
                                            href="chat.html"
                                            class="dropdown-item d-flex border-bottom"
                                        >
                                            <div
                                                class="drop-img cover-image"
                                                data-image-src="../../assets/img/faces/12.jpg"
                                            >
                                                <span
                                                    class="avatar-status bg-teal"
                                                ></span>
                                            </div>
                                            <div class="wd-90p">
                                                <div class="d-flex">
                                                    <h5 class="mb-0 name">
                                                        John Quil
                                                    </h5>
                                                </div>
                                                <p class="mb-0 desc">
                                                    Here are some products ...
                                                </p>
                                                <p
                                                    class="time mb-0 text-start float-start ms-2 mt-2"
                                                >
                                                    Feb 12 05:12 PM
                                                </p>
                                            </div>
                                        </a>
                                        <a
                                            href="chat.html"
                                            class="dropdown-item d-flex border-bottom"
                                        >
                                            <div
                                                class="drop-img cover-image"
                                                data-image-src="../../assets/img/faces/5.jpg"
                                            >
                                                <span
                                                    class="avatar-status bg-teal"
                                                ></span>
                                            </div>
                                            <div class="wd-90p">
                                                <div class="d-flex">
                                                    <h5 class="mb-0 name">
                                                        Liz Erd
                                                    </h5>
                                                </div>
                                                <p class="mb-0 desc">
                                                    I'm sorry but i'm not sure
                                                    how...
                                                </p>
                                                <p
                                                    class="time mb-0 text-start float-start ms-2 mt-2"
                                                >
                                                    Jan 29 03:16 PM
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="text-center dropdown-footer">
                                        <a
                                            class="btn btn-primary btn-sm btn-block text-center"
                                            href="chat.html"
                                            >VIEW ALL</a
                                        >
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item full-screen fullscreen-button">
                                <a
                                    class="new nav-link full-screen-link"
                                    href="javascript:void(0);"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="header-icon-svgs"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"
                                        /></svg
                                ></a>
                            </li>
                            <li class="nav-link search-icon d-lg-none d-block">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Search"
                                        />
                                        <span class="input-group-btn">
                                            <button
                                                type="reset"
                                                class="btn btn-default"
                                            >
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button
                                                type="submit"
                                                class="btn btn-default nav-link resp-btn"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    height="24px"
                                                    class="header-icon-svgs"
                                                    viewBox="0 0 24 24"
                                                    width="24px"
                                                    fill="#000000"
                                                >
                                                    <path
                                                        d="M0 0h24v24H0V0z"
                                                        fill="none"
                                                    />
                                                    <path
                                                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </li>
                            <li
                                class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2"
                            >
                                <a
                                    class="new nav-link profile-user d-flex"
                                    href=""
                                    data-bs-toggle="dropdown"
                                    ><img
                                        alt=""
                                        src="../../assets/img/faces/2.jpg"
                                        class=""
                                /></a>
                                <div class="dropdown-menu">
                                    <div
                                        class="menu-header-content p-3 border-bottom"
                                    >
                                        <div class="d-flex wd-100p">
                                            <div class="main-img-user">
                                                <img
                                                    alt=""
                                                    src="../../assets/img/faces/2.jpg"
                                                    class=""
                                                />
                                            </div>
                                            <div class="ms-3 my-auto">
                                                <h6
                                                    class="tx-15 font-weight-semibold mb-0"
                                                >
                                                   Welcome
                                                </h6>
                                                <span
                                                    class="dropdown-title-text subtext op-6 tx-12"
                                                    >{{ username }}</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="profile.html"
                                        ><i class="far fa-user-circle"></i
                                        >Profile</a
                                    >
                                    <a
                                        class="dropdown-item"
                                        href="javascript:;"
                                        v-on:click="
                                            () => {
                                                this.$router.push({
                                                    name: '2fa-manage',
                                                });
                                            }
                                        "
                                        style="cursor: pointer"
                                        ><i
                                            class="fa fa-key"
                                            aria-hidden="true"
                                        ></i
                                        >2FA Settings</a
                                    >
                                    <a
                                        class="dropdown-item"
                                        href="javascript:void(0);"
                                        v-on:click="logout"
                                        ><i
                                            class="far fa-arrow-alt-circle-left"
                                        ></i>
                                        Sign Out</a
                                    >
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
export default {
    name: "Header",
    data() {
        return {
            username: "",
            whmcs_service_id: "",
            app_name: "",
        };
    },
    methods: {
        logout(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure you want to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, logout!",
            }).then((result) => {
                if (result.isConfirmed) {
                    const auth = useAuthStore();
                    auth.logout();
                }
            });
        },
    },
    computed: {
        username() {
            const auth = useAuthStore();
            return auth.userDetail ? auth.userDetail.firstname : "User";
        },
        whmcs_service_id() {
            const auth = useAuthStore();
            return auth.appDetail ? auth.appDetail.id : null;
        },
        app_name() {
            const auth = useAuthStore();
            return auth.appDetail ? auth.appDetail.title : null;
        },
    },
};
</script>
