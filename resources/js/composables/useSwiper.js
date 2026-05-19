import {Navigation, Autoplay, Pagination} from 'swiper/modules'

export const useSwiper = () => {

    const modules = [Navigation, Autoplay, Pagination]

    const options = {
        modules,
        slidesPerView: 3,
        slidesPerGroup: 3,
        spaceBetween: 20,
        navigation: true,
        pagination: {
            clickable: true
        },
        // autoplay: {
        //     delay: 3000,
        //     pauseOnMouseEnter: true,
        //     disableOnInteraction: false
        // },
        autoplay: false,
        loop: true,
        speed: 600,
        breakpoints: {
            320: {slidesPerView: 1},
            768: {slidesPerView: 2},
            1024: {slidesPerView: 3}
        }
    }

    return {
        swiperOptions: options
    }

}
