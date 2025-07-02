const input = document.querySelector('input[name="key"]');
input.addEventListener("input", () => {
  if (input.value.trim() === "") {
    input.form.submit();
  }
});
