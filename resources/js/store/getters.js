const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  name: state => state.user.name,
  menu: state => state.menu,
  api: state => state.api,
  role: state => state.role
}
export default getters
