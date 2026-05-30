const BASE = "https://mercury.swin.edu.au/cos30043/s103988219/assignment/api";

export const api = {
  getJobs: async () => {
    const response = await fetch(`${BASE}/jobs.php`);
    return response.json();
  },
  getPosts: async () => {
    const response = await fetch(`${BASE}/posts.php`);
    return response.json();
  },
  getLogin: async (username, password) => {
    const response = await fetch(`${BASE}/login.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username: username, password: password })
    });
    return response.json();
  },
  createPost: async (post) => {
  const response = await fetch(`${BASE}/posts.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(post),
  });

  return response.json();
}
};