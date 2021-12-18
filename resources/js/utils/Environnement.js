
class Environnement {

    static getAll()
    {
        return window.axios.get('/api/environnements');
    }
}

export default Environnement;
