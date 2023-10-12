export default {
  methods: {
    getInteractionValues() {
      const params = { id: this.id };
      this.$api
        .get("/interacoes-filme", { params })
        .then((res) => {
          const response = res.data;

          if (response.sucesso) {
            const { dados } = response;

            this.watched = dados.assistido || false;
            this.saved = dados.salvo || false;
            this.liked = dados.curtido || false;

            console.log(dados.curtido || false)
      
            this.totalLiked = dados.totalCurtido;
            this.totalWatched = dados.totalAssistido;
            this.totalSaved = dados.totalSalvo;
          }
        })
        .catch(() => {});
    },
    captureLiked() {
      if (this.userLogged) {
        this.liked = !this.liked;
      } else {
        this.notifyAuthRequired();
      }
    },
    captureWatched() {
      if (this.userLogged) {
        this.watched = !this.watched;
      } else {
        this.notifyAuthRequired();
      }
    },
    captureSaved() {
      if (this.userLogged) {
        this.saved = !this.saved;
      } else {
        this.notifyAuthRequired();
      }
    },
  },

  data() {
    return {
      watched: false,
      saved: false,
      liked: false,

      totalLiked: 0,
      totalWatched: 0,
      totalSaved: 0,
    };
  },
};
