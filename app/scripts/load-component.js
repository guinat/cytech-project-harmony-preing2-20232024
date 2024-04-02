function loadComponent(componentPath, elementId) {
	fetch(componentPath)
		.then((response) => response.text())
		.then((html) => {
			document.getElementById(elementId).innerHTML = html;
		})
		.catch((err) => {
			console.error("Error loading component:", err);
		});
}

loadComponent("../components/header.html", "header");
loadComponent("../components/hero.html", "hero");
loadComponent("../components/sign-in-form.html", "sign-in-form");
loadComponent("../components/sign-up-form.html", "sign-up-form");
loadComponent("../components/demo.html", "demo");
