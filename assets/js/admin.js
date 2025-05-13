document.addEventListener("DOMContentLoaded", async () => {
    const table = document.getElementById("user-table");
    const users = await fetch("utilisateurs.json").then(res => res.json());
  
    users.forEach(user => {
      const row = document.createElement("tr");
      row.dataset.id = user.id;
  
      row.innerHTML = `
        <td>${user.id}</td>
        <td><input type="text" class="editable-login" value="${user.login}"></td>
        <td><input type="email" class="editable-email" value="${user.informations?.email || ''}"></td>
        <td><input type="text" class="editable-role" value="${user.role}"></td>
        <td>
          <button class="save-btn">💾</button>
          <span class="loader" style="display:none;">⏳</span>
        </td>
        <td><span class="status-msg"></span></td>
      `;
      table.appendChild(row);
    });
  
    document.querySelectorAll(".save-btn").forEach(button => {
      button.addEventListener("click", async () => {
        const row = button.closest("tr");
        const id = row.dataset.id;
        const login = row.querySelector(".editable-login").value;
        const email = row.querySelector(".editable-email").value;
        const role = row.querySelector(".editable-role").value;
  
        const loader = row.querySelector(".loader");
        const status = row.querySelector(".status-msg");
  
        loader.style.display = "inline";
        status.textContent = "";
  
        try {
          const res = await fetch("update_user.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id, login, email, role })
          });
  
          const data = await res.json();
          loader.style.display = "none";
  
          if (data.success) {
            status.textContent = "✅ Modifié";
          } else {
            status.textContent = "❌ Échec";
            row.querySelector(".editable-login").value = data.old.login;
            row.querySelector(".editable-email").value = data.old.email;
            row.querySelector(".editable-role").value = data.old.role;
          }
        } catch (err) {
          loader.style.display = "none";
          status.textContent = "❌ Erreur serveur";
        }
      });
    });
  });
  