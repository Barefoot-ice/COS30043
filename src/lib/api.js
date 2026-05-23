const BASE = "https://mercury.swin.edu.au/cos30043/s105338913/assignment/api";

export const api = {
  getJobs: () => {
    return fetch(`${BASE}/jobs.php`);
  },
};
