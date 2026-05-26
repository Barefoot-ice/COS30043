const BASE = "https://mercury.swin.edu.au/cos30043/s105338913/assignment/api";

export const api = {
  getJobs: async () => {
    const response = await fetch(`${BASE}/jobs.php`);
    return response.json();
  },
};
