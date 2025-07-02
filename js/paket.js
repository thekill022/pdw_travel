const modalEditEl = document.getElementById("modal-edit");
const modalEdit = new Flowbite.default.Modal(modalEditEl);

const modalDelEl = document.getElementById("deleteModal");
const modalDel = new Flowbite.default.Modal(modalDelEl);

if (document.getElementById("card").children.length > 0) {
  const edit = document.querySelectorAll(".edit");
  const del = document.querySelectorAll(".delete");

  edit.forEach((btn) => {
    btn.addEventListener("click", () => {
      console.log(btn.dataset);
      let id = btn.dataset.id;
      let nama = btn.dataset.nama;
      let harga = btn.dataset.harga;
      let deskripsi = btn.dataset.deskripsi;
      let foto = document.getElementById("fotoEd");

      setInputEdit(id, nama, harga, deskripsi);

      modalEdit.show();

      document.getElementById("submit").addEventListener("click", () => {
        let form = new FormData();
        form.append("id", document.getElementById("idEd").value);
        form.append("nama", document.getElementById("namaEd").value);
        form.append("harga", document.getElementById("hargaEd").value);
        form.append("deskripsi", document.getElementById("deskripsiEd").value);
        if (foto.files.length > 0) {
          form.append("foto", foto.files[0]);
        }
        form.append("edit", true);

        axios
          .post("http://localhost:8080/tugas_pdw/query/paket_crud.php", form)
          .then(async (res) => {
            if (res.data.status == 200) {
              await modalEdit.hide();
              alert("Berhasil Mengubah Data");
              location.reload();
            } else {
              await modalEdit.hide();
              alert("Terjadi kesalahan saat mengubah data, silahkan coba lagi");
            }
          })
          .catch((err) => {
            modalEdit.hide();
            alert("Error : " + err.message);
          });
      });
    });
  });

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
          .post("http://localhost:8080/tugas_pdw/query/paket_crud.php", form)
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

function setInputEdit(id, nama, harga, deskripsi) {
  document.getElementById("idEd").value = id;
  document.getElementById("namaEd").value = nama;
  document.getElementById("hargaEd").value = harga;
  document.getElementById("deskripsiEd").value = deskripsi;
}
