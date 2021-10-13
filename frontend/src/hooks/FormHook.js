import React, {Fragment, useState, useEffect} from 'react';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min';
import MultiRangeSlider from "../components/MultiRangeSlider/MultiRangeSlider";
import { PaginatedList } from '../components/React-paginated-list';
import { ramValues, hddValues } from '../consts/consts';
import { getLocationList, getServersList, postFilters } from '../services/api';

import { useForm } from 'react-hook-form';

const FormHook = () => {

    const { handleSubmit } = useForm();
    const [ min, setMin ] = useState([0]);
    const [ max, setMax ] = useState([72]);
    const [ loc, setLoc ] = useState([]);
    const [ hdd, setHdd ] = useState('');
    const [ location, setLocation ] = useState('');
    const [ servers, setServers ] = useState([]);
    const [ chekedState, setChekedState ] = useState(
        new Array(ramValues.length).fill(false)
    );
    const [ ram, setRam ] = useState(ramValues);

    let state = {};

    state.min = min;
    state.setMin = setMin;
    state.max = max;
    state.setMax = setMax;

    const onSubmit = (data) => {
        /* console.log(ram.filter(x => x != null));
        console.log(min, max);
        console.log(hdd);
        console.log(location); */
        const filters = {
            Storage:{
                start : min < 1 ? min*1000+"GB" : min+"TB",
                end : max < 1 ? max*1000+"GB" : max+"TB",
            },
            RAM : ram.filter(x => x != null),
            HardDisk_Type : hdd,
            Location : location
        };
        postFilters(filters)
        .then(items => {
            console.log(items);
            setServers(items)
        })
        
    }

    const handleOnChangeCheck = (position, val) => {
        const updatedCheckedState = chekedState.map((item,index) =>
            index === position ? !item : item
        );

        const updatedRam = updatedCheckedState.map((item,index) =>{
            return (
                item ? ramValues[index] : null
            )
        });

        setRam(updatedRam);
        setChekedState(updatedCheckedState);
    }

    const handleChangeHdd = (e) =>{
        console.log(e)
        setHdd(e.target.value);
    }

    const handleChangeLocation = (e) =>{
        console.log(e)
        setLocation(e.target.value);
    }

    useEffect(() => {
        let mounted = true;
        getLocationList()
        .then(items => {
            if(mounted) {
                setLoc(items)
            }
        })
        getServersList()
        .then(items => {
            if(mounted) {
                setServers(items)
            }
        })
        return () => mounted = false;
      },[]);

    return (
        <Fragment>
            <h1>Servers</h1>
            <div className="container-fluid">
                <div className="row">
                    <div className="col-12">
                        <h5>Filters</h5>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12">
                        <form onSubmit={handleSubmit(onSubmit)}>
                            <div className="row">
                                <div className="form-group mb-5 col-md-3">
                                    <label htmlFor="storage" className="form-label">Storage In TB</label>
                                    <MultiRangeSlider
                                        min={0}
                                        max={72}
                                        step={0.25}
                                        state={state}
                                        onChange={({ min, max }) => {
                                            setMin(min) 
                                            setMax(max)
                                        }}
                                    />
                                </div>
                                <div className="form-group mb-5 col-md-3">
                                    <label htmlFor="storage" className="form-label">Ram</label>
                                    <ul className="list-group">
                                        {ramValues.map((val, index) => {
                                            return (
                                                <li key={index} className={`list-group-item ${ (index!=5) ? "d-block" : "d-flex" }`}>
                                                    <div className="ram-list-item">
                                                        <div className="left-section">
                                                            <input
                                                                type="checkbox"
                                                                id={`custom-checkbox-${index}`}
                                                                name={val}
                                                                value={val}
                                                                checked={chekedState[index]}
                                                                onChange={()=> handleOnChangeCheck(index)}
                                                            />
                                                            <label htmlFor={`custom-checkbox-${index}`}>{val}</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            );
                                        })}
                                    </ul>
                                </div>
                                <div className="form-group mb-5 col-md-3">
                                    <label htmlFor="hd_type" className="form-label">Hard Disk Type</label>
                                    <input className="form-control" list="datalistOptions" id="hd_type" placeholder="Type to search..." onChange={(e)=>handleChangeHdd(e)} />
                                    <datalist id="datalistOptions">
                                        {hddValues.map((val, index) => {
                                            return(
                                                <option value={val} key={index} />
                                            )
                                        })}
                                    </datalist>
                                </div>
                                <div className="form-group mb-5 col-md-3">
                                    <label htmlFor="locationList" className="form-label">Locations</label>
                                    <input className="form-control" list="loclistOptions" id="locationList" placeholder="Type to search..." onChange={(e)=>handleChangeLocation(e)}/>
                                    <datalist id="loclistOptions">
                                        {loc.map((val, index) => {
                                            return(
                                                <option value={val} key={index} />
                                            )
                                        })}
                                    </datalist>
                                </div>
                            </div>
                                <div>
                                    <button className="btn btn-primary">Filter</button>
                                </div>
                        </form>
                    </div>
                </div>
                <div className="row">
                    <PaginatedList
                        list={servers}
                        itemsPerPage={10}
                        renderList={(list) => (
                        <>
                            <div className="col-12 table-responsive">
                                <table className="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Model</th>
                                            <th scope="col">RAM</th>
                                            <th scope="col">HDD</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {list.map((val, id) => {
                                            return (
                                                <tr key={id} className="fs-6">
                                                    <th scope="row">{val.id}</th>
                                                    <td>{val.Model}</td>
                                                    <td>{val.RAM}</td>
                                                    <td>{val.HDD}</td>
                                                    <td>{val.Location}</td>
                                                    <td>{val.Price}</td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table> 
                            </div>
                        </>
                        )}
                    />
                </div>
            </div>
        </Fragment>
    )
}

export default FormHook;