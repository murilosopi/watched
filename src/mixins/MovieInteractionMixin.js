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

        if (this.liked) this.totalLiked++;
        else this.totalLiked--;

        const params = {
          filme: this.id,
        };

        this.$api
          .post("/alterar-curtida-filme", params)
          .then((res) => {
            const response = res.data;

            if (!response.sucesso) {
              this.liked = !this.liked;

              if (this.liked) this.totalLiked++;
              else this.totalLiked--;

              throw response;
            }
          })
          .catch(() => {
            this.notifyUser({
              icon: "x-circle",
              title: "Ops",
              text: "não foi possível registrar sua curtida...",
              class: "danger",
            });
          });
      } else {
        this.notifyAuthRequired();
      }
    },
    captureWatched() {
      if (this.userLogged) {
        this.watched = !this.watched;

        if (this.watched) this.totalWatched++;
        else this.totalWatched--;

        const params = {
          filme: this.id,
        };

        this.$api
          .post("/alterar-assistido-filme", params)
          .then((res) => {
            const response = res.data;

            if (!response.sucesso) {
              this.watched = !this.watched;

              if (this.watched) this.totalWatched++;
              else this.totalWatched--;

              throw response;
            }
          })
          .catch(() => {
            this.notifyUser({
              icon: "x-circle",
              title: "Ops",
              text: "não foi possível registrar sua interação...",
              class: "danger",
            });
          });
      } else {
        this.notifyAuthRequired();
      }
    },
    captureSaved() {
      if (this.userLogged) {
        this.saved = !this.saved;

        if (this.saved) this.totalSaved++;
        else this.totalSaved--;

        const params = {
          filme: this.id,
        };

        this.$api
          .post("/alterar-salvo-filme", params)
          .then((res) => {
            const response = res.data;

            if (!response.sucesso) {
              this.saved = !this.saved;

              if (this.saved) this.totalSaved++;
              else this.totalSaved--;

              throw response;
            }
          })
          .catch(() => {
            this.notifyUser({
              icon: "x-circle",
              title: "Ops",
              text: "não foi possível registrar sua interação...",
              class: "danger",
            });
          });
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
