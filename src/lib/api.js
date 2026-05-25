const BASE = "https://mercury.swin.edu.au/cos30043/s105338913/assignment/api";

export const api = {
  getJobs: async () => {
    const response = await fetch(`${BASE}/jobs.php`);
    return (await response.json()).map((row) => ({
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
    }));
  },
  getJobDetail: async (jobId) => {
    const response = await fetch(`${BASE}/jobdetail.php?jobid=${jobid}`);
  },
};
