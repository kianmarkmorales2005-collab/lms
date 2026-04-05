import { auth, db } from "./firebase-config.js";
import { onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-auth.js";
import { ref, get } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-database.js";

// ==============================
// SIDEBAR TOGGLE
// ==============================
const navToggle = document.getElementById("navToggle");
if (navToggle) {
  navToggle.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-closed");
  });
}

// ==============================
// ACTIVE NAV ITEM
// ==============================
const navItems = document.querySelectorAll('.nav-item');
navItems.forEach(item => {
  item.addEventListener('click', function () {
    navItems.forEach(i => i.classList.remove('active'));
    this.classList.add('active');
  });
});

// ==============================
// FIREBASE — LOAD DASHBOARD DATA
// ==============================
onAuthStateChanged(auth, async (user) => {

  // If not logged in, redirect to login
  if (!user) {
    window.location.href = "login.html";
    return;
  }
  console.log("Logged in UID:", user.uid);
  try {
    // ── 1. Load user profile ──
 const userSnap = await get(ref(db, "users/" + user.uid));


    if (userSnap.exists()) {
      const userData = userSnap.val();

      // Welcome message
      const welcomeText = document.getElementById("welcomeText");
      if (welcomeText) welcomeText.textContent = "Welcome, " + userData.name;

      // Sidebar name
      const sidebarName = document.getElementById("sidebarName");
      if (sidebarName) sidebarName.textContent = userData.name;

      // Year level
      const yearLevel = document.getElementById("yearLevel");
      if (yearLevel) yearLevel.textContent = userData.year || "N/A";

      // GWA
      const gwaValue = document.getElementById("gwaValue");
      if (gwaValue) gwaValue.textContent = userData.gwa || "N/A";
    }

    // ── 2. Load enrolled courses count ──
 const enrollSnap = await get(ref(db, "enrollments"));
let enrollCount = 0;

if (enrollSnap.exists()) {
  const enrollments = enrollSnap.val();
  Object.values(enrollments).forEach(enrollment => {
    // Check if studentId exists before comparing
    if (enrollment.studentId && enrollment.studentId.trim() === user.uid.trim()) {
      enrollCount++;
    }
  });
}

const enrolledCount = document.getElementById("enrolledCount");
if (enrolledCount) enrolledCount.textContent = enrollCount;
    // ── 3. Load upcoming deadlines ──
    const assignSnap = await get(ref(db, "assignments"));
    const deadlineList = document.getElementById("deadlineList");
    const activitiesCount = document.getElementById("activitiesCount");

    if (deadlineList) {
      if (!assignSnap.exists()) {
        deadlineList.innerHTML = `<div style="color:var(--muted);font-size:0.85rem;">No upcoming deadlines.</div>`;
        if (activitiesCount) activitiesCount.textContent = "0";
      } else {
        const assignments = assignSnap.val();
        let deadlineHTML = "";
        let count = 0;
        const now = new Date();

        Object.values(assignments).forEach(a => {
          const dueDate = new Date(a.dueDate);

          if (dueDate >= now) {
            count++;
            const diffDays = Math.ceil((dueDate - now) / (1000 * 60 * 60 * 24));

            let badgeLabel = "";
            let badgeClass = "red";

            if (diffDays === 0) {
              badgeLabel = "Today";
            } else if (diffDays === 1) {
              badgeLabel = "Tomorrow";
            } else if (diffDays <= 7) {
              badgeLabel = dueDate.toLocaleDateString('en-US', { weekday: 'long' });
            } else {
              badgeLabel = dueDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
              badgeClass = "green";
            }

            deadlineHTML += `
              <div class="deadline-item">
                <div>
                  <div style="font-weight:500">${a.title}</div>
                  <div style="font-size:0.74rem;color:var(--muted)">${a.courseId}</div>
                </div>
                <span class="badge ${badgeClass}">${badgeLabel}</span>
              </div>`;
          }
        });

        deadlineList.innerHTML = deadlineHTML || `<div style="color:var(--muted);font-size:0.85rem;">No upcoming deadlines.</div>`;
        if (activitiesCount) activitiesCount.textContent = count;
      }
    }

  } catch (error) {
    console.error("Dashboard error:", error);
  }
});