const modalDelEl = document.getElementById("deleteModal");
const modalDel = new Flowbite.default.Modal(modalDelEl);

if (document.getElementById("userData").children.length > 0) {
  const del = document.querySelectorAll(".delete");

  del.forEach((btn) => {
    btn.addEventListener("click", () => {
      modalDel.show();

      let id = btn.dataset.id;

      const delBtn = document.getElementById("postDelete");
      delBtn.addEventListener("click", () => {
        const form = new FormData();
        form.append("id", id);
        form.append("delete", true);

        axios
          .post("http://localhost:8080/tugas_pdw/query/jadwal_crud.php", form)
          .then(async (res) => {
            if (res.data.status == 200) {
              await modalDel.hide();
              alert("Berhasil Menghapus Data");
              location.reload();
            } else {
              await modalDel.hide();
              alert(
                "Terjadi kesalahan saat menghapus data, silahkan coba lagi"
              );
            }
          })
          .catch((err) => {
            modalDel.hide();
            alert("Error : " + err.message);
          });
      });
    });
  });
}
