import axios from '@/utils/request'; // 导入http中创建的axios实例

export default {
    //获取登录
    isLogin() {
        return axios.get('/api/isLogin');
    }
    // 其他接口…………
};