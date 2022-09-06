import logo from './logo.svg';
import './App.css';
import {Agregar} from './Agregar';
import {Cambiar} from './Cambiar';
import {Listar} from './Listar';

export default function App(){
  return (
     <div>
        <div className="col-1"></div>
        <div class="App col-10">

          <h1 class="h1">Biblioteca Valen </h1>
          <h2 class="h2">Agregar un libro</h2>
          <Agregar />
          <h2 className="h2"> Cambiar un libro</h2>
          <Cambiar/>
          <h2 className="h2"> Borrar un libro</h2>
          <h2 className="h2"> Listas los libros</h2>
          <Listar/>
        </div>
     </div>
  );
}

/*function App() {
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.js</code> and save to reload.
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header>
    </div>
  );
}
export default App;
*/