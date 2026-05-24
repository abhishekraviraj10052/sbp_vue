<template>
    <div class="main-sidemenu">
        <div class="slide-left disabled" id="slide-left">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="#7b8191"
                width="24"
                height="24"
                viewBox="0 0 24 24"
            >
                <path
                    d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"
                />
            </svg>
        </div>
        <ul
            class="side-menu"
            v-if="$route.name == 'app-list' || $route.name == 'app-manage'"
        >
            <li class="slide">
                <a
                    class="side-menu__item active"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({ name: 'app-list' });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1"
                        id="Layer_1"
                        x="0px"
                        y="0px"
                        width="22"
                        height="24"
                        viewBox="0 0 12 12"
                        style="
                            enable-background: new 0 0 12 12;
                            margin-right: 8px;
                        "
                        xml:space="preserve"
                    >
                        <path
                            class="st0"
                            d="M7.2,6.9c0,1.1,0,2.2,0,3.3c0,0.9-0.6,1.6-1.4,1.8C5.7,12,5.5,12,5.4,12c-1,0-1.9,0-2.9,0  c-1.1,0-1.8-0.8-1.8-1.8c0-2.2,0-4.3,0-6.5c0-1.1,0.8-1.8,1.8-1.8c1,0,2,0,2.9,0c0.9,0,1.6,0.6,1.8,1.5c0,0.1,0,0.3,0,0.4  C7.2,4.8,7.2,5.8,7.2,6.9z M3,3C2.8,3,2.7,3,2.5,3C2,3,1.8,3.2,1.8,3.7c0,2.1,0,4.3,0,6.4c0,0.5,0.3,0.7,0.7,0.7c0.9,0,1.9,0,2.8,0  c0.5,0,0.7-0.2,0.7-0.7C6,8,6,5.8,6,3.7c0-0.1,0-0.1,0-0.2C6,3.3,5.8,3.1,5.5,3C5.3,3,5,3,4.8,3C4.7,3.4,4.5,3.6,4.2,3.6  c-0.2,0-0.4,0-0.6,0C3.3,3.6,3.1,3.4,3,3.1C3,3.1,3,3,3,3z"
                        ></path>
                        <path
                            class="st0"
                            d="M7.8,10.2c0-0.4,0-0.8,0-1.2C7.9,9,7.9,9,8,9c0.5,0,1,0,1.6,0c0.4,0,0.7-0.2,0.7-0.7c0-2.1,0-4.3,0-6.4  c0-0.4-0.2-0.7-0.7-0.7c-0.2,0-0.3,0-0.5,0c0,0,0,0,0,0.1C8.9,1.6,8.7,1.8,8.3,1.8c-0.1,0-0.3,0-0.4,0c-0.4,0-0.6-0.2-0.7-0.6  c-0.3,0-0.6-0.1-0.9,0.1c0,0-0.1,0-0.1,0C5.8,1.2,5.4,1.2,5,1.2c0,0-0.1,0-0.1,0C5,0.8,5.3,0.5,5.6,0.3C5.9,0.1,6.2,0,6.5,0  c1,0,2.1,0,3.1,0c1,0,1.7,0.8,1.7,1.8c0,2.2,0,4.4,0,6.6c0,1-0.8,1.7-1.7,1.8C9.1,10.2,8.5,10.2,7.8,10.2  C7.9,10.2,7.8,10.2,7.8,10.2z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">My Apps</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="logout"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Logout</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu" v-else>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({ name: 'app-list' });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        style="margin-right: 0"
                    >
                        <path
                            fill="currentColor"
                            d="M11.67 3.87L9.9 2.1 0 12l9.9 9.9 1.77-1.77L3.54 12z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Back To My Apps</span>
                </a>
            </li>
            <li class="slide mt-10">
                <a
                    class="side-menu__item active"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="this.$router.push({ name: 'app-detail' })"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12C20,14.4 19,16.5 17.3,18C15.9,16.7 14,16 12,16C10,16 8.2,16.7 6.7,18C5,16.5 4,14.4 4,12A8,8 0 0,1 12,4M14,5.89C13.62,5.9 13.26,6.15 13.1,6.54L11.81,9.77L11.71,10C11,10.13 10.41,10.6 10.14,11.26C9.73,12.29 10.23,13.45 11.26,13.86C12.29,14.27 13.45,13.77 13.86,12.74C14.12,12.08 14,11.32 13.57,10.76L13.67,10.5L14.96,7.29L14.97,7.26C15.17,6.75 14.92,6.17 14.41,5.96C14.28,5.91 14.15,5.89 14,5.89M10,6A1,1 0 0,0 9,7A1,1 0 0,0 10,8A1,1 0 0,0 11,7A1,1 0 0,0 10,6M7,9A1,1 0 0,0 6,10A1,1 0 0,0 7,11A1,1 0 0,0 8,10A1,1 0 0,0 7,9M17,9A1,1 0 0,0 16,10A1,1 0 0,0 17,11A1,1 0 0,0 18,10A1,1 0 0,0 17,9Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Main Dashboard</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({ name: 'dns-list' });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zM7 19c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zM7 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Manage DNS</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({
                                name: 'announcement-list',
                            });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M12 15c1.66 0 2.99-1.34 2.99-3L15 6c0-1.66-1.34-3-3-3S9 4.34 9 6v6c0 1.66 1.34 3 3 3zm-1.2-9.1c0-.66.54-1.2 1.2-1.2s1.2.54 1.2 1.2l-.01 6.2c0 .66-.53 1.2-1.19 1.2s-1.2-.54-1.2-1.2V5.9zm6.5 6.1c0 3-2.54 5.1-5.3 5.1S6.7 15 6.7 12H5c0 3.41 2.72 6.23 6 6.72V22h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Announcements</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:void(0);"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M12,23A1,1 0 0,1 11,22V19H7A2,2 0 0,1 5,17V7A2,2 0 0,1 7,5H21A2,2 0 0,1 23,7V17A2,2 0 0,1 21,19H16.9L13.2,22.71C13,22.89 12.76,23 12.5,23H12M13,17V20.08L16.08,17H21V7H7V17H13M3,15H1V3A2,2 0 0,1 3,1H19V3H3V15M9,9H19V11H9V9M9,13H17V15H9V13Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Notifications</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({
                                name: 'rewarded-ads-list',
                            });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M19 7C17.9 7 17 7.9 17 9V11C17 12.1 17.9 13 19 13H21V15H17V17H21C22.1 17 23 16.1 23 15V13C23 11.9 22.1 11 21 11H19V9H23V7H19M9 7V17H13C14.1 17 15 16.1 15 15V9C15 7.9 14.1 7 13 7H9M11 9H13V15H11V9M3 7C1.9 7 1 7.9 1 9V17H3V13H5V17H7V9C7 7.9 6.1 7 5 7H3M3 9H5V11H3V9Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Rewarded Ads</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({
                                name: 'dashboard-ads-list',
                            });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M19 7C17.9 7 17 7.9 17 9V11C17 12.1 17.9 13 19 13H21V15H17V17H21C22.1 17 23 16.1 23 15V13C23 11.9 22.1 11 21 11H19V9H23V7H19M9 7V17H13C14.1 17 15 16.1 15 15V9C15 7.9 14.1 7 13 7H9M11 9H13V15H11V9M3 7C1.9 7 1 7.9 1 9V17H3V13H5V17H7V9C7 7.9 6.1 7 5 7H3M3 9H5V11H3V9Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Dashboard Ads</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10M17,11H15V9H17V11M13,11H11V9H13V11M9,11H7V9H9V11Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Clients Feedbacks</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M6,3A1,1 0 0,1 7,4V4.88C8.06,4.44 9.5,4 11,4C14,4 14,6 16,6C19,6 20,4 20,4V12C20,12 19,14 16,14C13,14 13,12 11,12C8,12 7,14 7,14V21H5V4A1,1 0 0,1 6,3M7,7.25V11.5C7,11.5 9,10 11,10C13,10 14,12 16,12C18,12 18,11 18,11V7.5C18,7.5 17,8 16,8C14,8 13,6 11,6C9,6 7,7.25 7,7.25Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Reports</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({
                                name: 'vpn-list',
                            });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M20.995 6.9a.998.998 0 0 0-.548-.795l-8-4a1 1 0 0 0-.895 0l-8 4a1.002 1.002 0 0 0-.547.795c-.011.107-.961 10.767 8.589 15.014a.987.987 0 0 0 .812 0c9.55-4.247 8.6-14.906 8.589-15.014zM12 19.897C5.231 16.625 4.911 9.642 4.966 7.635L12 4.118l7.029 3.515c.037 1.989-.328 9.018-7.029 12.264z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">VPN</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M7 7H5A2 2 0 0 0 3 9V17H5V13H7V17H9V9A2 2 0 0 0 7 7M7 11H5V9H7M14 7H10V17H12V13H14A2 2 0 0 0 16 11V9A2 2 0 0 0 14 7M14 11H12V9H14M20 9V15H21V17H17V15H18V9H17V7H21V9Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">API</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M17.6,9.48l1.84-3.18c0.16-0.31,0.04-0.69-0.26-0.85c-0.29-0.15-0.65-0.06-0.83,0.22l-1.88,3.24 c-2.86-1.21-6.08-1.21-8.94,0L5.65,5.67c-0.19-0.29-0.58-0.38-0.87-0.2C4.5,5.65,4.41,6.01,4.56,6.3L6.4,9.48 C3.3,11.25,1.28,14.44,1,18h22C22.72,14.44,20.7,11.25,17.6,9.48z M7,15.25c-0.69,0-1.25-0.56-1.25-1.25 c0-0.69,0.56-1.25,1.25-1.25S8.25,13.31,8.25,14C8.25,14.69,7.69,15.25,7,15.25z M17,15.25c-0.69,0-1.25-0.56-1.25-1.25 c0-0.69,0.56-1.25,1.25-1.25s1.25,0.56,1.25,1.25C18.25,14.69,17.69,15.25,17,15.25z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Upgrade App</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="
                        () => {
                            this.$router.push({
                                name: 'maintainence-mode',
                            });
                        }
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M9,15c-2.67,0-8,1.34-8,4v2h16v-2C17,16.34,11.67,15,9,15z"
                        ></path>
                        <path
                            d="M22.1,6.84c0.01-0.11,0.02-0.22,0.02-0.34c0-0.12-0.01-0.23-0.03-0.34l0.74-0.58c0.07-0.05,0.08-0.15,0.04-0.22l-0.7-1.21 c-0.04-0.08-0.14-0.1-0.21-0.08L21.1,4.42c-0.18-0.14-0.38-0.25-0.59-0.34l-0.13-0.93C20.36,3.06,20.29,3,20.2,3h-1.4 c-0.09,0-0.16,0.06-0.17,0.15L18.5,4.08c-0.21,0.09-0.41,0.21-0.59,0.34l-0.87-0.35c-0.08-0.03-0.17,0-0.21,0.08l-0.7,1.21 c-0.04,0.08-0.03,0.17,0.04,0.22l0.74,0.58c-0.02,0.11-0.03,0.23-0.03,0.34c0,0.11,0.01,0.23,0.03,0.34l-0.74,0.58 c-0.07,0.05-0.08,0.15-0.04,0.22l0.7,1.21c0.04,0.08,0.14,0.1,0.21,0.08l0.87-0.35c0.18,0.14,0.38,0.25,0.59,0.34l0.13,0.93 C18.64,9.94,18.71,10,18.8,10h1.4c0.09,0,0.16-0.06,0.17-0.15l0.13-0.93c0.21-0.09,0.41-0.21,0.59-0.34l0.87,0.35 c0.08,0.03,0.17,0,0.21-0.08l0.7-1.21c0.04-0.08,0.03-0.17-0.04-0.22L22.1,6.84z M19.5,7.75c-0.69,0-1.25-0.56-1.25-1.25 s0.56-1.25,1.25-1.25s1.25,0.56,1.25,1.25S20.19,7.75,19.5,7.75z"
                        ></path>
                        <path
                            d="M19.92,11.68l-0.5-0.87c-0.03-0.06-0.1-0.08-0.15-0.06l-0.62,0.25c-0.13-0.1-0.27-0.18-0.42-0.24l-0.09-0.66 C18.12,10.04,18.06,10,18,10h-1c-0.06,0-0.11,0.04-0.12,0.11l-0.09,0.66c-0.15,0.06-0.29,0.15-0.42,0.24l-0.62-0.25 c-0.06-0.02-0.12,0-0.15,0.06l-0.5,0.87c-0.03,0.06-0.02,0.12,0.03,0.16l0.53,0.41c-0.01,0.08-0.02,0.16-0.02,0.24 c0,0.08,0.01,0.17,0.02,0.24l-0.53,0.41c-0.05,0.04-0.06,0.11-0.03,0.16l0.5,0.87c0.03,0.06,0.1,0.08,0.15,0.06l0.62-0.25 c0.13,0.1,0.27,0.18,0.42,0.24l0.09,0.66C16.89,14.96,16.94,15,17,15h1c0.06,0,0.12-0.04,0.12-0.11l0.09-0.66 c0.15-0.06,0.29-0.15,0.42-0.24l0.62,0.25c0.06,0.02,0.12,0,0.15-0.06l0.5-0.87c0.03-0.06,0.02-0.12-0.03-0.16l-0.52-0.41 c0.01-0.08,0.02-0.16,0.02-0.24c0-0.08-0.01-0.17-0.02-0.24l0.53-0.41C19.93,11.81,19.94,11.74,19.92,11.68z M17.5,13.33 c-0.46,0-0.83-0.38-0.83-0.83c0-0.46,0.38-0.83,0.83-0.83s0.83,0.38,0.83,0.83C18.33,12.96,17.96,13.33,17.5,13.33z"
                        ></path>
                        <path
                            d="M4.74,9h8.53c0.27,0,0.49-0.22,0.49-0.49V8.49c0-0.27-0.22-0.49-0.49-0.49H13c0-1.48-0.81-2.75-2-3.45V5.5 C11,5.78,10.78,6,10.5,6S10,5.78,10,5.5V4.14C9.68,4.06,9.35,4,9,4S8.32,4.06,8,4.14V5.5C8,5.78,7.78,6,7.5,6S7,5.78,7,5.5V4.55 C5.81,5.25,5,6.52,5,8H4.74C4.47,8,4.25,8.22,4.25,8.49v0.03C4.25,8.78,4.47,9,4.74,9z"
                        ></path>
                        <path
                            d="M9,13c1.86,0,3.41-1.28,3.86-3H5.14C5.59,11.72,7.14,13,9,13z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Maintenance Mode</span>
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M17 3H5C3.9 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H11.81C11.42 20.34 11.17 19.6 11.07 18.84C9.5 18.31 8.66 16.6 9.2 15.03C9.61 13.83 10.73 13 12 13C12.44 13 12.88 13.1 13.28 13.29C15.57 11.5 18.83 11.59 21 13.54V7L17 3M15 9H5V5H15V9M15.75 21L13 18L14.16 16.84L15.75 18.43L19.34 14.84L20.5 16.25L15.75 21"
                        ></path>
                    </svg>
                    <span class="side-menu__label"
                        >App Storage Preferences</span
                    >
                </a>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:void(0);"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Logs</span
                    ><i class="angle fe fe-chevron-right"></i>
                </a>
                <ul class="slide-menu" style="display: none">
                    <li>
                        <a class="slide-item" href="javascript:;">Panel Logs</a>
                    </li>
                    <li>
                        <a class="slide-item" href="javascript:;"
                            >Firebase Logs</a
                        >
                    </li>
                    <li>
                        <a class="slide-item" href="javascript:;">Api Logs</a>
                    </li>
                </ul>
            </li>
            <li class="slide">
                <a
                    class="side-menu__item"
                    data-bs-toggle="slide"
                    href="javascript:;"
                    v-on:click="logout"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"
                        ></path>
                    </svg>
                    <span class="side-menu__label">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
import { useAuthStore } from "@/stores/auth";
export default {
    name: "SideBarContent",
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
};
</script>
