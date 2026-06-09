import { initializeApp } from "firebase/app";
import { getMessaging } from "firebase/messaging";

const firebaseConfig = {
    apiKey: "AIzaSyBc_zs27Xl-2q1xJLXfxIPFTorDxkw3khY",
    authDomain: "sbp-vue.firebaseapp.com",
    projectId: "sbp-vue",
    storageBucket: "sbp-vue.firebasestorage.app",
    messagingSenderId: "1056030228863",
    appId: "1:1056030228863:web:425e39c54998506008da4a",
};

const app = initializeApp(firebaseConfig);
export const messaging = getMessaging(app);
