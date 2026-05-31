const BASE = "https://mercury.swin.edu.au/cos30043/s105139158/assignment/api";

const mapArrayToJob = (row) => {
  return {
    job_id: row[0],
    job_title: row[1],
    category: row[2],
    location: row[3],
    employment_type: row[4],
    salary_range: row[5],
    job_level: row[6],

    required_skills: JSON.parse(row[7]),
    preferred_qualifications: JSON.parse(row[8]),

    job_description: row[9],
    application_deadline: row[10],
    posted_date: row[11],
    company: row[12],
    supervisor: row[13],
    positions_available: row[14],
    start_date: row[15],

    tags: JSON.parse(row[16]),

    approved: row[17] == 1,
    approvalRead: row[18] == 1,
  };
};
const mapArrayToUser = (row) => {
  return {
    acc_id: row[0],
    username: row[1],
    email: row[2],
    password: row[3],
    created_at: row[4],
    role: row[5]
  };
};

export const api = {
  getJobs: async () => {
    const response = await fetch(`${BASE}/jobs.php`);
    return (await response.json()).map((row) => mapArrayToJob(row));
  },
  getJobDetail: async (jobId) => {
    const response = await fetch(`${BASE}/jobdetail.php?jobid=${jobId}`);
    return mapArrayToJob(await response.json());
  },
  setJobApproved: async (jobId, approved) => {
    const res = await fetch(
      `${BASE}/jobapprove.php?jobid=${jobId}&approved=${approved}`,
    );
    console.log(await res.text());
  },
  getPosts: async () => {
    const response = await fetch(`${BASE}/posts.php`);
    return response.json();
  },
  getLogin: async (email, password) => {
    const response = await fetch(`${BASE}/login.php?email=${email}&password=${password}`);
    return response.json();
  },
  likePost: async (postId) => {
  const response = await fetch(`${BASE}/posts.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      action: "like",
      post_id: postId
    })
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
},
newUser: async (username, email, password)=> {
    const response = await fetch(`${BASE}/newUser.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username: username, email: email, password: password })
    });
    return response.json();
  },

  getAccount: async (id) => {
      const response = await fetch(`${BASE}/accountget.php?account_id=${id}`);
      return mapArrayToUser(await response.json());
  },
    editAccount: async (id, username, email, password) => {
      const response = await fetch(`${BASE}/accountedit.php?account_id=${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({username: username, email: email, password: password})
    });
    console.log(response);
    return response;
  },
  editJob: async (job_id, category, location, employment_type, job_level, job_description, application_deadline, supervisor, positions_available, start_date) => {
      const response = await fetch(`${BASE}/jobedit.php`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({job_id: job_id, category: category, location: location, employment_type: employment_type, job_level: job_level, job_description: job_description, application_deadline: application_deadline, supervisor: supervisor, positions_available: positions_available, start_date: start_date})
    });
    console.log(response);
    return response;
  },
  deleteJob: async (job_id) => {
    const response = await fetch(`${BASE}/jobdelete.php`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({job_id: job_id})
    });
    console.log(response);
    return response;
  }
};
