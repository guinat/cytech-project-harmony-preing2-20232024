tailwind.config = {
	theme: {
		container: {
			center: true,
			padding: "2rem",
		},
		screens: {
			sm: "480px",
			md: "768px",
			lg: "976px",
			xl: "1440px",
		},
		fontFamily: {
			sans: ["", "sans-serif"],
			serif: ["", "serif"],
		},
		extend: {
			colors: {
				primary: "#da373d",
				secondary: "#72e2ed",
			},
			backgroundImage: {
				hero: "url(assets/hero/hero-bg.png)",
			},
		},
	},
};
