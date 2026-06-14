const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");
const menuClose = document.getElementById("menu-close");
const menuBackdrop = document.getElementById("menu-backdrop");

menuToggle.addEventListener("click", () =>
  mobileMenu.classList.remove("hidden"),
);

const appName = document.getElementById("app-name");
const mq = window.matchMedia("(min-width: 768px)");

function toggleAppName() {
  if (mq.matches) {
    appName.classList.remove("hidden");
  } else {
    appName.classList.add("hidden");
  }
}

toggleAppName();
mq.addEventListener("change", toggleAppName);

menuClose.addEventListener("click", () => mobileMenu.classList.add("hidden"));
menuBackdrop.addEventListener("click", () =>
  mobileMenu.classList.add("hidden"),
);

const createTaskBtns = document.querySelectorAll('[data-modal="create-task"]');
const createTaskModal = document.getElementById("create-task-modal");
const modalClose = document.getElementById("modal-close");
const modalBackdrop = document.getElementById("modal-backdrop");

function autofillDateTime() {
  const dueDateInput = document.querySelector(
    '#create-task-form [name="due_date"]',
  );
  const dueTimeInput = document.querySelector(
    '#create-task-form [name="due_time"]',
  );

  const now = new Date();
  const yyyy = now.getFullYear();
  const mm = String(now.getMonth() + 1).padStart(2, "0");
  const dd = String(now.getDate()).padStart(2, "0");
  const hh = String(now.getHours()).padStart(2, "0");
  const min = String(now.getMinutes()).padStart(2, "0");

  if (dueDateInput && !dueDateInput.value) {
    dueDateInput.value = `${yyyy}-${mm}-${dd}`;
  }
  if (dueTimeInput && !dueTimeInput.value) {
    dueTimeInput.value = `${hh}:${min}`;
  }
}

createTaskBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    createTaskModal.classList.remove("hidden");
    mobileMenu.classList.add("hidden");

    document.getElementById("modal-title").textContent = "Create task";
    document.getElementById("create-task-form").action =
      "/tasks/create";
    document.querySelector(
      "#create-task-form button[type='submit']",
    ).textContent = "Create";
    document.getElementById("create-task-form").reset();
    autofillDateTime();
  });
});

modalClose.addEventListener("click", () =>
  createTaskModal.classList.add("hidden"),
);
modalBackdrop.addEventListener("click", () =>
  createTaskModal.classList.add("hidden"),
);

const checkboxes = document.querySelectorAll(".task-checkbox");
const selectAllCheckbox = document.getElementById("select-all");
const bulkActions = document.getElementById("bulk-actions");
const selectedCount = document.getElementById("selected-count");
const editSelectedBtn = document.getElementById("edit-selected");

const toggleBulkActions = (show) => {
  bulkActions.classList.toggle("hidden", !show);
  bulkActions.classList.toggle("flex", show);
};

checkboxes.forEach((cb) => {
  cb.addEventListener("change", () => {
    const selected = document.querySelectorAll(".task-checkbox:checked");
    toggleBulkActions(selected.length > 0);
    selectedCount.textContent = `${selected.length} selected`;

    if (editSelectedBtn) {
      editSelectedBtn.style.display = selected.length === 1 ? "" : "none";
    }

    selectAllCheckbox.checked = selected.length === checkboxes.length;
  });
});



selectAllCheckbox.addEventListener("change", () => {
  checkboxes.forEach((cb) => {
    cb.checked = selectAllCheckbox.checked;
  });

  const selected = document.querySelectorAll(".task-checkbox:checked");
  toggleBulkActions(selected.length > 0);
  selectedCount.textContent = `${selected.length} selected`;

  if (editSelectedBtn) {
    editSelectedBtn.style.display = selected.length === 1 ? "" : "none";
  }
});

document.getElementById("delete-selected").addEventListener("click", () => {
  const selected = [...document.querySelectorAll(".task-checkbox:checked")];
  const ids = selected.map((cb) => cb.dataset.id);

  fetch("/tasks/delete", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ids }),
  }).then(() => location.reload());
});

document.getElementById("complete-selected").addEventListener("click", () => {
  const selected = [...document.querySelectorAll(".task-checkbox:checked")];
  const ids = selected.map((cb) => cb.dataset.id);

  fetch("/tasks/complete", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ids }),
  }).then(() => location.reload());
});

const filterBtns = document.querySelectorAll("[data-filter]");
const taskTiles = document.querySelectorAll(".task-tile");

taskTiles.forEach((tile) => {
  tile.classList.add("cursor-pointer");

  tile.addEventListener("click", (e) => {
    if (e.target.classList.contains("task-checkbox")) return;

    const checkbox = tile.querySelector(".task-checkbox");
    checkbox.checked = !checkbox.checked;

    checkbox.dispatchEvent(new Event("change"));
  });
});

if (!taskTiles) {
  document.getElementById("sort-toggle").classList.add("hidden");
}

filterBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    filterBtns.forEach((b) => b.classList.remove("filter-active"));
    btn.classList.add("filter-active");

    const filter = btn.dataset.filter;
    const today = new Date().toISOString().split("T")[0];

    taskTiles.forEach((tile) => {
      const dueDate = tile.dataset.dueDate;
      const status = tile.dataset.status;

      let show = false;

      if (filter === "all") {
        show = true;
      } else if (filter === "today") {
        show = dueDate && dueDate.startsWith(today);
      } else if (filter === "scheduled") {
        show = status === "PENDING";
      } else if (filter === "completed") {
        show = status === "COMPLETED";
      } else if (filter === "overdue") {
        show = status === "OVERDUE";
      }

      tile.style.display = show ? "" : "none";
    });
  });
});

if (editSelectedBtn) {
  editSelectedBtn.addEventListener("click", () => {
    document.getElementById("modal-title").textContent = "Edit Task";
    const selected = document.querySelector(".task-checkbox:checked");
    const tile = selected.closest(".task-tile");

    document.querySelector("#create-task-form [name='title']").value = tile
      .querySelector("h3")
      .textContent.trim();
    document.querySelector("#create-task-form [name='desc']").value =
      tile.querySelector("p")?.textContent.trim() ?? "";
    document.querySelector("#create-task-form select[name='priority']").value =
      tile.dataset.priority;

    if (tile.dataset.dueDate) {
      const [datePart, timePart] = tile.dataset.dueDate.split(" ");
      document.querySelector("#create-task-form [name='due_date']").value =
        datePart;
      document.querySelector("#create-task-form [name='due_time']").value =
        timePart?.slice(0, 5) ?? "";
    }

    document.getElementById("create-task-form").action =
      `/tasks/edit/${tile.dataset.id}`;
    document.querySelector(
      "#create-task-form button[type='submit']",
    ).textContent = "Save";

    document.getElementById("modal-title").textContent = "Edit Task";

    createTaskModal.classList.remove("hidden");
  });
}

const priorityOrder = { HIGH: 3, MEDIUM: 2, LOW: 1 };
let sortDescending = true;

document.getElementById("sort-toggle").addEventListener("click", () => {
  const container = document.querySelector(".flex.flex-col.gap-3");
  const tiles = [...document.querySelectorAll(".task-tile")];

  sortDescending = !sortDescending;

  tiles.sort((a, b) => {
    const diff =
      priorityOrder[a.dataset.priority] - priorityOrder[b.dataset.priority];
    return sortDescending ? -diff : diff;
  });

  tiles.forEach((tile) => container.appendChild(tile));

  // update icon
  const icon = document.querySelector("#sort-toggle i");
  icon.className = sortDescending
    ? "fa-solid fa-arrow-down"
    : "fa-solid fa-arrow-up";
});
