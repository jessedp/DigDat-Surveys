<template>
    <div class="container survey">

        <template v-if="dataLoading">
            <div class="card-content">
                Loading...
            </div>
        </template>

        <template v-else>

            <div class="section">
                <div class="card">
                    <div class="card-content questions">
                        <template v-if="submitted">
                            Thank you for participating in the survey! <a :href="resultsPath">View Results</a>
                        </template>

                        <template v-else>
                            <div v-for="question in survey.questions" class="section question">
                                <p>{{ question.question }}</p>
                                <span class="select">
                                    <select v-model="question.answer">
                                        <option value="">Select An Answer</option>
                                        <option v-for="option in question.options" :value="option.id">{{ option.label
                                            }}</option>
                                    </select>
                                </span>
                            </div>
                        </template>

                    </div>
                    <div class="card-footer" v-if="!submitted">
                        <button type="button" class="button is-fullwidth is-primary" @click="submitSurvey">Submit
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>

  export default {

    name: 'TakeSurvey',

    props: ['resultsPath'],

    data() {
      return {
        submitted: false,
        dataLoading: false,
        survey_id: window.survey.id,
        survey: {},
      }
    },

    created() {
      this.getSurvey();
    },

    methods: {

      getSurvey() {
        this.dataLoading = true;
        let survey_slug = window.survey.slug;
        axios.get('/api/survey/' + survey_slug).then(res => {
          let data = res.data;

          data.questions.forEach(question => {
            question.answer = '';
          });
          this.survey = data;
          this.dataLoading = false;
        })

      },

      submitSurvey() {
        let data = this.survey;
        axios.post('/api/survey/submit', data).then(res => {
          this.submitted = true;
        })
      }

    }

  }
</script>
