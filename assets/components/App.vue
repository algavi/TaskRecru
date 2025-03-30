<template>
  <section class="hero bg-light">
    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
      <div v-if="jobs.length === 0">
        <h1>Dneška žadná robota</h1>
      </div>

      <div
          v-else
          v-for="(job, index) in jobs"
          :key="index"
          class="card"
          style="width: 18rem; margin: 10px 0;"
      >
        <div class="card-body">
          <h5 class="card-title">{{ job.title }}</h5>
          <p class="card-text">{{ truncatedDescription(job.description) }}</p>
        </div>

        <ul class="list-group list-group-flush">
          <li
              class="list-group-item"
              v-for="(workfield, wIndex) in job.workfields"
              :key="wIndex"
          >
            {{ workfield.name }}
          </li>
        </ul>

        <div v-if="job.salary && job.salary.visible" style="margin: 10px;">
          <strong>
            {{ job.salary.min }}
            <span v-if="job.salary.max">
              - {{ job.salary.max }}
            </span>
            Kč
          </strong>
        </div>

        <div class="card-body">
          <a :href="`/prace/${job.job_id}`" class="card-link">Detail</a>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "JobsView",
  data() {
    return {
      jobs: []
    };
  },
  mounted() {
    fetch('/api/jobs')
    .then(response => response.json())
    .then(json => {
      this.jobs = json.data;
    })
    .catch(error => {
      console.error("Chyba při načítání /api/jobs:", error);
    });
  },
  methods: {
    truncatedDescription(htmlString) {
      if (!htmlString) return '';
      const text = htmlString.replace(/(<([^>]+)>)/gi, '');
      return text.substring(0, 200);
    }
  }
};
</script>

<style scoped>
/* Případné styly */
</style>