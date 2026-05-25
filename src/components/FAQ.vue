<script></script>

<template>
  <h1>FAQ</h1>
  <h3>Frequently asked questions</h3>
<!-- Assumes bootstrap is installed -->
<div class="d-flex flex-column">
  <!-- repeatable FAQ block -->
  <div>
    <a class="text-primary" data-bs-toggle="collapse" href="#q1" role="button" aria-expanded="false" aria-controls="q1">
      What is this site for?
    </a>
  </div>
  <div class="collapse" id="q1"> 
    <p>
        This site allows you to view/make/apply for jop positions, as well as chat with other potential jobseekers or employers also connected.
    </p>
  </div>
  <!-- repeatable FAQ block -->
  <div>
    <a class="text-primary" data-bs-toggle="collapse" href="#q2" role="button" aria-expanded="false" aria-controls="q2">
      Is the chat function moderated?
    </a>
  </div>
  <div class="collapse" id="q2"> 
    <p>
        Not in the slightest in its current form, further improvements are planned to ensure moderators can delete unprofessional behaviour in the chat function.
    </p>
  </div>
  <!-- spacer -->
  <div>
    <a class="text-primary" data-bs-toggle="collapse" href="#q3" role="button" aria-expanded="false" aria-controls="q3">
      How do i veiw Job listings?
    </a>
  </div>
  <div class="collapse" id="q3"> 
    <p>
        Simply head over to the job listings page in the nav bar to view possible listings
    </p>
  </div>
<!-- spacer -->
   <div>
    <a class="text-primary" data-bs-toggle="collapse" href="#q4" role="button" aria-expanded="false" aria-controls="q4">
      How do i access the chat function?
    </a>
  </div>
  <div class="collapse" id="q4"> 
    <p>
      I don't actually know
    </p>
  </div>
<!-- spacer -->
   <div>
    <a class="text-primary" data-bs-toggle="collapse" href="#q5" role="button" aria-expanded="false" aria-controls="q5">
      Why can't i access the chat/creat a job listing?
    </a>
  </div>
  <div class="collapse" id="q5"> 
    <p>
      These features are only available for registered account holders, please sign up to access these features
    </p>
  </div>
<!-- spacer -->
</div>

</template>
