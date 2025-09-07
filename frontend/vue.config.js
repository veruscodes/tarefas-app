const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true, // ✅ Mude para true ou array vazio
  devServer: {
    client: {
      overlay: false
    }
  }
})