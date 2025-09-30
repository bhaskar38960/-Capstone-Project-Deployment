// assets/js/script.js
document.addEventListener('DOMContentLoaded', function(){
  const searchEl = document.querySelector('#courseSearch');
  if(searchEl){
    searchEl.addEventListener('input', function(){
      const q = this.value.trim();
      fetch('/capstone-elearning/api/search.php?q=' + encodeURIComponent(q))
        .then(r => r.json())
        .then(data => {
          const target = document.querySelector('#coursesList');
          if (!target) return;
          if(data.length === 0){
            target.innerHTML = '<div class="col-12">No courses found.</div>';
            return;
          }
          target.innerHTML = data.map(c => `
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="card card-course h-100">
                <div class="card-body d-flex flex-column">
                  <h5 class="course-title">${c.title}</h5>
                  <p class="text-muted small">${c.short_desc}</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="/capstone-elearning/course.php?id=${c.id}" class="btn btn-outline-primary btn-sm">View</a>
                    <span class="fw-bold">${c.price==0? 'Free': '$'+c.price}</span>
                  </div>
                </div>
              </div>
            </div>`).join('');
        })
    });
  }
});
