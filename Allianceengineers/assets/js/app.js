document.addEventListener("DOMContentLoaded", () => {
  const fileInput = document.querySelector('input[type="file"][multiple]');
  if (fileInput) {
    fileInput.addEventListener("change", () => {
      const count = fileInput.files.length;
      const button = fileInput.closest("form")?.querySelector("button");
      if (button && count) button.textContent = `Upload ${count} Photo${count === 1 ? "" : "s"}`;
    });
  }
});
