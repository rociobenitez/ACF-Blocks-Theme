/**
 * Hero Background Video - Performance and Accessibility
 */
document.addEventListener("DOMContentLoaded", function () {
	const bgVideos = document.querySelectorAll(".hero__bg-video");

	if (!bgVideos.length) return;

	// Check if user prefers reduced motion
	const prefersReducedMotion = window.matchMedia(
		"(prefers-reduced-motion: reduce)"
	).matches;

	// Check if connection is slow (if supported)
	const isSlowConnection =
		navigator.connection &&
		(navigator.connection.effectiveType === "slow-2g" ||
			navigator.connection.effectiveType === "2g" ||
			navigator.connection.saveData);

	bgVideos.forEach(function (bgVideoContainer) {
		const video = bgVideoContainer.querySelector("video");

		if (!video) return;

		// Hide video for reduced motion or slow connections
		if (prefersReducedMotion || isSlowConnection) {
			bgVideoContainer.style.display = "none";
			return;
		}

		// Pause video when not in viewport (Intersection Observer)
		if ("IntersectionObserver" in window) {
			const observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						const video = entry.target.querySelector("video");
						if (!video) return;

						if (entry.isIntersecting) {
							video.play().catch(() => {}); // Ignore play errors
						} else {
							video.pause();
						}
					});
				},
				{
					threshold: 0.1,
				}
			);

			observer.observe(bgVideoContainer);
		}

		// Handle visibility change (when tab is not active)
		document.addEventListener("visibilitychange", function () {
			if (document.hidden) {
				video.pause();
			} else {
				video.play().catch(() => {}); // Ignore play errors
			}
		});
	});
});
