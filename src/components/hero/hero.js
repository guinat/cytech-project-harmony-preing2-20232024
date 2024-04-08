document.addEventListener("DOMContentLoaded", function () {
	const SignUpButton = document.getElementById("SignUpButton");
	const SignUpModal = document.getElementById("SignUpModal");
	const CloseButton = document.getElementById("CloseButton");

	SignUpButton.addEventListener("click", function () {
		SignUpModal.classList.toggle("hidden");
	});

	CloseButton.addEventListener("click", function () {
		SignUpModal.classList.add("hidden");
	});
});
