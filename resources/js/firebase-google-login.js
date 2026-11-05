import { initializeApp } from "firebase/app";
import {
    getAuth,
    GoogleAuthProvider,
    signInWithPopup,
} from "firebase/auth";

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
    measurementId: import.meta.env.VITE_FIREBASE_MEASUREMENT_ID,
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

document.addEventListener("DOMContentLoaded", function () {
    const loginButtons = document.querySelectorAll("[data-firebase-google-login]");

    if (!loginButtons.length) {
        return;
    }

    loginButtons.forEach(function (loginButton) {
        loginButton.addEventListener("click", async function () {
            const originalText = loginButton.innerHTML;
            const redirectAfterLogin = loginButton.dataset.redirectAfterLogin || "/dashboard";

            try {
                loginButton.disabled = true;
                loginButton.innerHTML = "Memproses...";

                const result = await signInWithPopup(auth, provider);
                const idToken = await result.user.getIdToken();

                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content");

                const response = await fetch("/auth/firebase-google", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        idToken: idToken,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Login Google gagal.");
                }

                window.location.href = redirectAfterLogin || data.redirect || "/dashboard";
            } catch (error) {
                if (error.code !== "auth/popup-closed-by-user") {
                    alert(error.message || "Login Google gagal. Silakan coba lagi.");
                }

                loginButton.disabled = false;
                loginButton.innerHTML = originalText;
            }
        });
    });
});
