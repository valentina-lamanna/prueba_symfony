import React , {useState, useEffect} from 'react';
import './Partes.css';
import axios from 'axios';

export function Listar(){
    const [libros, setLibros]=useState([])
    const baseUrl ="https://symfony-dev.frba.utn.edu.ar/book";
    const peticionGet=async()=>{
        await axios.get(baseUrl)
            .then(response=>{
                const objetc = response.data.data;
                console.log(objetc)
                objetc.map(o=> o.title);
                setLibros(objetc)
                //setLibros((prev) =>{return [o.title, ...prev]})
            }).catch(error=>{
                console.log(error);
            })
    }



    return(
        <div class="listar">
            <button class="boton" onClick={()=> peticionGet()}>Listar</button>
            <button class="boton" onClick={()=> setLibros([])}>Ocultar</button>

            <ul >{libros.map(libro => <li>{libro.title}</li>)}</ul>
        </div>

    );
}

