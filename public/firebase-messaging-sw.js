importScripts(
    "https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js",
);

importScripts(
    "https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js",
);

firebase.initializeApp({
    apiKey: "AIzaSyBc_zs27Xl-2q1xJLXfxIPFTorDxkw3khY",
    authDomain: "sbp-vue.firebaseapp.com",
    databaseURL: "https://XXXX.firebaseio.com",
    projectId: "sbp-vue",
    storageBucket: "sbp-vue.firebasestorage.app",
    messagingSenderId: "1056030228863",
    appId: "1:1056030228863:web:425e39c54998506008da4a",
    measurementId: "G-KQVLVY1KRD",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    self.registration.showNotification(payload.notification.title, {
        body: payload.notification.body,
        icon: "/favicon.ico",
    });
});
