<template>
  <div class="about">
    <h2>About us</h2>
    <p class="descript">
    We’re a passionate group of developers who love turning ideas into real, useful experiences.
    Our goal is to create a space where people can easily discover 
    <span class="highlight">jobs that truly match</span> their skills, interests, and ambitions.
    At the same time, we want to make it simple to 
    <span class="highlight">connect with professionals</span> and grow together.
    </p>
    <br>
    <h2>Our Team</h2>

    <div class="team-container">
      <div class="team-card" v-for="member in team" :key="member.email">
        <img :src="member.photo" alt="profile" class="avatar">    
        <p class="name">{{ member.name }}</p>
        <p class="email">{{ member.email }}</p>

        
        <ul class="contributions">
          <li v-for="(item, index) in member.contributions" :key="index">
            {{ item }}
          </li>
        </ul>

      </div>
    </div>
  </div>
</template>

<script>
import danAvatar from '../assets/danAvatar.webp'
import daveAvatar from '../assets/daveAvatar.png'
import mynAvatar from '../assets/mynAvatar.webp'
import alexAvatar from '../assets/alexAvatar.webp'
import chuckAvatar from '../assets/chuckAvatar.webp'
import michAvatar from '../assets/michAvatar.webp'

export default {
  data() {
    return {
      team: [
        {
          name: "Daniel Martin",
          email: "102514765@student.swin.edu.au",
          role: "Frontend Developer",
          photo: danAvatar,
          contributions: [
            "Built responsive UI components",
            "Improved page load performance",
            "Collaborated on design system"
          ]
        },
        {
          name: "David Micallef",
          email: "105139158@student.swin.edu.au",
          role: "Backend Developer",
          photo: daveAvatar,
          contributions: [
            "Built responsive UI components",
            "Improved page load performance",
            "Collaborated on design system"
          ]
        },
        {
          name: "Myn Ma",
          email: "104677958@student.swin.edu.au",
          role: "UI/UX Designer",
          photo: mynAvatar,
          contributions: [
            "Job Listings Page",
            "Job Detail View",
            "About Page"
          ]
        },
        {
          name: "Alexander Rigato",
          email: "105338913@student.swin.edu.au",
          role: "Full Stack Developer",
          photo: alexAvatar,
          contributions: [
            "Built responsive UI components",
            "Improved page load performance",
            "Collaborated on design system"
          ]
        },
        {
          name: "Charles Murdoch-Yardley",
          email: "103988219@student.swin.edu.au",
          role: "Project Manager",
          photo: chuckAvatar,
          contributions: [
            "Built responsive UI components",
            "Improved page load performance",
            "Collaborated on design system"
          ]
        },
        {
          name: "Michael Attardi",
          email: "102096755@student.swin.edu.au",
          role: "DevOps Engineer",
          photo: michAvatar,
          contributions: [
            "Built responsive UI components",
            "Improved page load performance",
            "Collaborated on design system"
          ]
        }
      ]
    };
  }
};
</script>

<style scoped>
.about {
  text-align: center;
  padding: 20px;
}

.team-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 per row */
  gap: 30px;
  margin-top: 20px;
}

.team-card {
  background: #f9f9f9;
  padding: 20px;
  border-radius: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%; /* circle */
  object-fit: cover;
  margin-bottom: 10px;
}

.name {
  color: #2563eb;
  font-weight: bold;
}

.email {
  font-size: 0.9rem;
  color: #777;
}

.contributions {
  margin-top: 10px;
  text-align: center;
  padding-left: 20px;
  font-size: 0.9rem;
  color: #555;
  list-style: none;
}

.about {
  background: #f9fafb;
  padding: 30px;
  border-radius: 16px;
}

.about .descript {
  max-width: 700px;
  margin: 0 auto;
  font-size: 1.05rem;
  line-height: 1.7;
  color: #555;
}

.highlight {
  color: #2563eb;
  font-weight: 500;
}

</style>