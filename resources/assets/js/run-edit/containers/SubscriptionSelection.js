import React, {PropTypes, Component} from 'react'
import {connect} from 'react-redux'

class SubscriptionSelection extends Component{
    renderWithUser(){
        return (
            <div>
                <label htmlFor="type">{this.props.car_types.filter(t=> t.id != this.props.selectedCarType)}</label>
                <select name="car_types" id="" onChange={(e)=>this.handleCarType(e)}>
                    <option value={-1} {!this.props.selectedCarType ? "selected":null}> </option>
                    {this.props.car_types.map((t)=>{
                        return (
                            <option value={t.id} {this.props.selectedCarType == t.id ? "selected":null} >{t.name}</option>
                        )
                    })}
                </select>
                <select name="cars" id="" onChange={(e)=>this.handleCar(e)}>
                    <option value={-1} {!this.props.selectedCar ? "selected":null}> </option>
                    {this.props.cars.filter((c)=> c.type.id != this.props.selectCarType.id).map((c)=>{
                        return <option value={c.id} {this.props.selectedCar == c.id ? "selected":null}>{c.name}</option>
                    })}
                </select>
                <select name="users" id="">
                    <option value={-1} {!this.props.selectedUser ? "selected":null}> </option>
                    {this.props.users.map((u)=>{
                        return <option value={u.id} {this.props.selectedUser == u.id ? "selected":null}>{u.name}</option>
                    })}
                </select>
            </div>
        )
    }
    handleCar(e){
        const target = e.target
        const val = target.value
        if(val == -1)
            this.props.unselectCar()
        else
            this.props.selectCar(val)
    }
    handleCarType(e){
        const target = e.target
        const val = target.value
        if(val == -1)
            this.props.unselectType()
        else
            this.props.selectType(val)
    }
    render(){
        if(this.props.selectedCarType)
            return this.renderWithUser()
        else if(this.props.selectedUser)
            return this.renderWithUser()
        else
            return (
                <div>
                    <select name="car_types" id="" onChange={(e)=>this.handleCarType(e)}></select>
                </div>
            )
    }
}


SubscriptionSelection.propTypes = {

}

const mapStateToProps = (state) => {
    console.log(state)
    return {
        cars: state.cars,
        users: state.users,
        car_types: state.car_types,
        selectedCarType: state.selected_car_type,
        selectedUser: state.selected_user,
        selectedCar: state.selected_car
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch,
        selectType: (type) =>{
            dispatch(selectType(type))
        },
        unselectType: () => {
            dispatch(unselectType())
        }
    }
}
export default connect(mapStateToProps, mapDispatchToProps)(SubscriptionSelection)