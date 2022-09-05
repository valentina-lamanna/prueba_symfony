import React , {useState, useEffect} from 'react';
import './Agregar.css';
import axios from 'axios';
//import {Button} from '@material-ui/core';

export function Agregar(){
    const [libro, setLibro] = useState("");
    const [libros, setLibros] = useState([]);
    const[data, setData]=useState([])
    const[respuesta, setRespuesta]=useState({
        id: '',
        title: '',
        image:''
    })
    useEffect(()=>{

    },[libros])


    const [modalEditar, setModalEditar]= useState(false);
    const [modalInsertar, setModalInsertar]= useState(false);
    const [modalEliminar, setModalEliminar]= useState(false);
    const baseUrl ="https://symfony-dev.frba.utn.edu.ar/book";

    const mostrarLibros='';
    const abrirCerrarModalInsertar=()=>{
        setModalInsertar(!modalInsertar);
    }


    const abrirCerrarModalEditar=()=>{
        setModalEditar(!modalEditar);
    }

    const abrirCerrarModalEliminar=()=>{
        setModalEliminar(!modalEliminar);
    }

    const peticionPost=async()=>{
        await axios.post(baseUrl+'/post/create', respuesta)
            .then(response=>{
                setData((prev) => ([...prev, response.data])); //data.concat(response.data)
                abrirCerrarModalInsertar();
            })
            .catch(error=>{
                console.log(error);
            })
    }

    const peticionGet=async()=>{
        await axios.get(baseUrl)
            .then(response=>{
                const libros = response.data.map(l => l.title);
                setData(libros);
            }).catch(error=>{
                console.log(error);
            })
    }

    return(
        <div className="form">
            <h5>Ingresa el nombre del libro</h5>
            <h5>{libro}</h5>
            <h5>{respuesta.title}</h5>
            <input type="text" onChange={(e) => {setLibro(e.target.value);
                                                        setRespuesta((prevProfile) => (
                                                                {...prevProfile ,
                                                                    ['title']: e.target.value }
                                                            )
                                                        )}}
                   value={libro} />
            <br/>
            <br/>
            <button class="boton" onClick={()=>{
                                            peticionPost();
                                            setLibro('');
                                            setRespuesta({'id': '',
                                                'title': '',
                                                'image':''})
                                            }}> Enviar</button>
        </div>
    );
}


