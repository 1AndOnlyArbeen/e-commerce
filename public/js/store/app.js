/* ══ App Initialization ══
   This file must be loaded LAST — after all other store/*.js files */

/* Merge guest cart if user just logged in */
if (window.__STORE_DATA__.justLoggedIn) {
    mergeCartAfterLogin();
}

/* Load cart and render products */
loadCart();
