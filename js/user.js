console.log("hai");
const button = document.getElementById("cari");
const table = document.getElementById("userData");
let username = document.getElementById("username");

class userId {
  id;

  constructor(id) {
    this.id = id;
  }

  setId(id) {
    this.id = id;
  }

  getId() {
    return this.id;
  }
}

let users = new userId(0);

// load all data
document.addEventListener("DOMContentLoaded", () => {
  loadAllUser();
});

button.addEventListener("click", () => {
  if (username.value.trim() !== "") {
    let formdata = new FormData();
    formdata.append("srcUname", username.value.trim());

    axios
      .post("http://localhost:8080/tugas_pdw/query/user_crud.php", formdata)
      .then((res) => {
        if (res.data.status == 200) {
          table.innerHTML = "";
          for (let i = 0; i < res.data.data.length; i++) {
            table.innerHTML += `
              <tr class="border-t hover:bg-gray-50">
                  <td class="px-4 py-2 flex items-center gap-2">
                    <img src="../assets/icons/user-color.jpeg" alt="user" class="w-8 h-8 rounded-full">
                    ${res.data.data[i].nama}
                  </td>
                  <td class="px-4 py-2">${res.data.data[i].username}</td>
                  <td class="px-4 py-2 text-center">
                    <button data-name="${
                      res.data.data[i].nama
                    }" data-username="${res.data.data[i].username}" data-id="${
              res.data.data[i].id
            }" class="edit bg-yellow-600 text-white px-4 py-1 rounded-md mx-1">Edit</button>
                    <button class="delete ${
                      res.data.data[i].status == 1
                        ? "bg-red-600"
                        : "bg-green-600"
                    } text-white px-4 py-1 rounded-md mx-1">${
              res.data.data[i].status == 1 ? "Nonaktifkan" : "Aktifkan"
            }</button>
                  </td>
                </tr>
            `;
          }
        } else {
          table.innerHTML = `
            <tr>
              <td colspan=4 class="text-center px-4 py-2">
                No Data Found
              </td>
            </tr>
          `;
        }
      });
  }
});

// edit
const modalEl = document.getElementById("modalEdit");
const modalEdit = new Flowbite.default.Modal(modalEl);

// delete
const modalDel = document.getElementById("deleteModal");
const modalDels = new Flowbite.default.Modal(modalDel);

function loadAllUser() {
  let formdata = new FormData();
  formdata.append("loadAll", "true");

  axios
    .post("http://localhost:8080/tugas_pdw/query/user_crud.php", formdata)
    .then((res) => {
      table.innerHTML = "";
      for (let i = 0; i < res.data.data.length; i++) {
        table.innerHTML += `
              <tr class="border-t hover:bg-gray-50">
                  <td class="px-4 py-2 flex items-center gap-2">
                    <img src="../assets/icons/user-color.jpeg" alt="user" class="w-8 h-8 rounded-full">
                    ${res.data.data[i].nama}
                  </td>
                  <td class="px-4 py-2">${res.data.data[i].username}</td>
                  <td class="px-4 py-2 text-center">
                    <button data-name="${res.data.data[i].nama}" data-id="${
          res.data.data[i].id
        }" data-username="${
          res.data.data[i].username
        }" class="edit bg-yellow-600 text-white px-4 py-1 rounded-md mx-1">Edit</button>
                    <button data-id="${res.data.data[i].id}" class="delete ${
          res.data.data[i].status == 1 ? "bg-red-600" : "bg-green-600"
        } text-white px-4 py-1 rounded-md mx-1">${
          res.data.data[i].status == 1 ? "Nonaktifkan" : "Aktifkan"
        }</button>
                  </td>
                </tr>
            `;
      }
      const edit = document.getElementsByClassName("edit");

      Array.from(edit).forEach((btn) => {
        btn.addEventListener("click", () => {
          modalEdit.show();

          let id = document.getElementById("id");
          let nameEdit = document.getElementById("nameEdit");
          let usernameEdit = document.getElementById("usernameEdit");

          id.value = btn.dataset.id;
          nameEdit.value = btn.dataset.name;
          usernameEdit.value = btn.dataset.username;
        });
      });

      const deleting = document.getElementsByClassName("delete");

      Array.from(deleting).forEach((btn) => {
        btn.addEventListener("click", () => {
          users.setId(btn.dataset.id);
          modalDels.show();
        });
      });
    });
}

username.addEventListener("change", (e) => {
  if (e.target.value.trim() == "") {
    loadAllUser();
  }
});

const btnEditData = document.getElementById("postEdit");

btnEditData.addEventListener("click", (e) => {
  e.preventDefault();

  let id = document.getElementById("id");
  let nameEdit = document.getElementById("nameEdit");
  let usernameEdit = document.getElementById("usernameEdit");
  let passwordEdit = document.getElementById("passwordEdit");

  let form = new FormData();
  form.append("id", id.value);
  form.append("nama", nameEdit.value);
  form.append("username", usernameEdit.value);
  form.append("password", passwordEdit.value);
  form.append("updateUsr", true);

  if (nameEdit.value.trim().length < 3) {
    alert("nama terlalu pendek");
    return;
  } else if (usernameEdit.value.trim().length < 5) {
    alert("username terlalu pendek");
    return;
  } else if (
    passwordEdit.value.trim().length < 6 &&
    passwordEdit.value.trim() != ""
  ) {
    alert("password terlalu pendek");
    return;
  }

  axios
    .post("http://localhost:8080/tugas_pdw/query/user_crud.php", form)
    .then((res) => {
      if (res.data.status == "success") {
        modalEdit.hide();
        alert("Berhasil Mengupdate Data Member");
        loadAllUser();
      } else {
        alert(res.data.error);
        modalEdit.hide();
      }
    });
});

const deleteBtn = document.getElementById("postDelete");
deleteBtn.addEventListener("click", () => {
  let form = new FormData();
  form.append("id", users.getId());
  console.log(users.getId());
  form.append("deleteUsr", true);

  axios
    .post("http://localhost:8080/tugas_pdw/query/user_crud.php", form)
    .then((res) => {
      if (res.data.status == "success") {
        modalDels.hide();
        alert("Berhasil Mengubah Status Akun Member");
        loadAllUser();
      } else {
        modalDels.hide();
        alert(res.data.message);
      }
    });
});
