function [ new_state ] = Round10( state,key,s_box )
%UNTITLED5 Summary of this function goes here
%   Detailed explanation goes here
 %step 1
        [ state1 ] = subsituteBytes( state , s_box );
        %step 2
        [ state2 ] = shiftRows(state1);
        %step 3
        key = keyExpansion( key, 10 );
        [ new_state ] = AddKey(key , state2 );

end

