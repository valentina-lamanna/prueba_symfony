import React , {useState, useEffect} from 'react';
import './Partes.css';
import axios from 'axios';
//import {Button} from '@material-ui/core';

export function Cambiar(){
    const [libros, setLibros] = useState([]);
    const [data, setData] = useState([]);
    const [libro, setLibro] = useState('');
    const[respuesta, setRespuesta]=useState({
        id: '',
        title: '',
        image:''
    })

      useEffect(()=>{
          const funcionPiola= async()=> {
                      await peticionGet()
                  }
          funcionPiola();
      },[])


    const baseUrl ="https://symfony-dev.frba.utn.edu.ar/book";



    const peticionPost=async()=>{
        await axios.post(baseUrl+'/edit/{' + respuesta.id +'}', respuesta)
            .then(response=>{
                setData((prev) => ([...prev, response.data])); //data.concat(response.data)
                abrirCerrarModalInsertar();
            })
            .catch(error=>{
                console.log(respuesta)
                console.log(error);
            })
    }

    const peticionGet=async()=>{
        await axios.get(baseUrl)
            .then(response=>{
                let data = response.data.data;
                setLibros(data);
            }).catch(error=>{
                console.log(error);
            })
    }

    return(
        <div className="form">
            <h5>¿Que libro queres cambiar?</h5>
            <p>Nombre el titulo a cambiar</p>
            <select>
                <option value='0' selected>Seleccione una opcion</option>
                {libros.map(l => <option value={l.id}
                                         onClick={(e) => {
                                            setRespuesta((prevProfile) => (
                                                        {...prevProfile ,
                                                        ['id']: e.target.value }

                                                )

                                            )}}
                                >{'Titulo : ' + l.title + ' con id : ' + l.id}</option>)}
            </select>
            <p>Nuevo titulo</p>
            <input type="text" onChange={(e) => {setLibro(e.target.value);
                setRespuesta((prevProfile) => (
                        {...prevProfile ,
                            ['title']: e.target.value }
                    )
                )}}
                   value={libro} />
            <br/>
            <button className='boton' onClick={()=> peticionPost()}>Enviar</button>
        </div>
    );
}


